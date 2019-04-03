<?php
/**
 * Defines Ingenerator\KohanaLogger\KohanaLogger
 *
 * @author     Andrew Coulton <andrew@ingenerator.com>
 * @copyright  2014 inGenerator Ltd
 * @licence    BSD
 */

namespace Ingenerator\KohanaLogger;
use Psr\Log\AbstractLogger;

/**
 * Provides a PSR3 logger interface to the native Kohana logging
 *
 * @package Logger
 * @see     spec\Ingenerator\KohanaLogger\KohanaLoggerSpec
 */
class KohanaLogger extends AbstractLogger {

	/**
	 * @var \Log
	 */
	protected $log;

	/**
	 * @param \Log $log the global Kohana log from \Kohana::$log
	 */
	public function __construct(\Log $log = NULL)
	{
		$this->log = $log ? : \Kohana::$log;
	}

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param string  $level  a PSR LogLevel constant
	 * @param string $message
	 * @param array  $context
	 *
	 * @return null
	 */
	public function log($level, $message, array $context = array())
	{
		$level = $this->convert_psr_to_kohana_level($level);

		if ($exception = $this->get_exception_from_context($context))
		{
			$message .= \PHP_EOL.\Kohana_Exception::text($exception);
		}
		elseif ($message instanceof \Exception)
		{
			$context['exception'] = $message;
			$message = \Kohana_Exception::text($message);
		}

		$this->log->add($level, $message, array(), $context);
	}

	/**
	 * @param string $level
	 *
	 * @return int
	 * @throws \InvalidArgumentException
	 */
	protected function convert_psr_to_kohana_level($level)
	{
		$const_name = 'Log::'.\strtoupper($level);

		if (\defined($const_name))
		{
			return \constant($const_name);
		}
		else
		{
			throw new \InvalidArgumentException("Unknown log level $level");
		}
	}

	/**
	 * @param array $context
	 *
	 * @return \Exception
	 */
	protected function get_exception_from_context(array $context)
	{
		if (isset($context['exception']) AND ($context['exception'] instanceof \Exception))
		{
			return $context['exception'];
		}
		else
		{
			return NULL;
		}
	}


}
