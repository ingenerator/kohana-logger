<?php
/**
 * Defines KohanaLoggerSpec - specifications for Ingenerator\KohanaLogger\KohanaLogger
 *
 * @author     Andrew Coulton <andrew@ingenerator.com>
 * @copyright  2014 inGenerator Ltd
 * @licence    BSD
 */

namespace spec\Ingenerator\KohanaLogger;

use Prophecy\Argument;
use spec\ObjectBehavior;

/**
 *
 * @see Ingenerator\KohanaLogger\KohanaLogger
 */
class KohanaLoggerSpec extends ObjectBehavior
{
    /**
     * Use $this->subject to get proper type hinting for the subject class
     * @var \Ingenerator\KohanaLogger\KohanaLogger
     */
	protected $subject;

	/**
	 * @param \Log $log
	 */
	function let($log)
	{
		$this->beConstructedWith($log);
	}

	function it_is_initializable()
    {
		$this->subject->shouldHaveType('Ingenerator\KohanaLogger\KohanaLogger');
	}

	function it_is_a_psr3_logger()
	{
		$this->subject->shouldHaveType('Psr\Log\LoggerInterface');
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_to_a_provided_kohana_log($log)
	{
		$this->subject->info('Some message');
		$log->add(Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_debug_messages($log)
	{
		$this->subject->debug('some message');
		$log->add(\Log::DEBUG, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_info_messages($log)
	{
		$this->subject->info('some message');
		$log->add(\Log::INFO, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_notice_messages($log)
	{
		$this->subject->notice('some message');
		$log->add(\Log::NOTICE, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_warning_messages($log)
	{
		$this->subject->warning('some message');
		$log->add(\Log::WARNING, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_error_messages($log)
	{
		$this->subject->error('some message');
		$log->add(\Log::ERROR, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_critical_messages($log)
	{
		$this->subject->critical('some message');
		$log->add(\Log::CRITICAL, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_alert_messages($log)
	{
		$this->subject->alert('some message');
		$log->add(\Log::ALERT, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_emergency_messages($log)
	{
		$this->subject->emergency('some message');
		$log->add(\Log::EMERGENCY, 'some message', Argument::cetera())->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_passes_context_as_additional($log)
	{
		$e = new \Exception('Foo');
		$this->subject->info('Something that we caught', array('exception' => $e));
		$log->add(\Log::INFO, Argument::type('string'), array(), array('exception' => $e))->shouldHaveBeenCalled();
	}

	/**
	 * @param \Log $log
	 */
	function it_appends_exception_type_and_message_to_log_message($log)
	{
		$e = new \Exception('Foo');
		$this->subject->info('We handled this', array('exception' => $e));
		$log->add(\Log::INFO, 'We handled this'.\PHP_EOL.\Kohana_Exception::text($e), Argument::cetera())->shouldHaveBeenCalled();
	}

	function it_copes_if_context_exception_is_not_exception_instance()
	{
		$this->subject->info('Problem', array('exception' => 'Uh-oh - this is not an exception'));
	}

	/**
	 * @param \Log $log
	 */
	function it_can_accept_exception_as_message($log)
	{
		$e = new \Exception('Problem');
		$this->subject->alert($e);
		$log->add(\Log::ALERT, \Kohana_Exception::text($e), array(), array('exception' => $e))->shouldHaveBeenCalled();
	}

	function it_throws_on_invalid_level()
	{
		$this->shouldThrow('\InvalidArgumentException')
			->during('log', array('random', 'bad level'));
	}

	/**
	 * @param \Log $log
	 */
	function it_logs_to_global_kohana_log_if_not_provided_a_log_instance($log)
	{
		$old_log = \Kohana::$log;
		try
		{
			\Kohana::$log = $log->getWrappedObject();
			$this->beConstructedWith();
			$this->subject->info('some message');
		}
		catch (\Exception $e)
		{
			\Kohana::$log = $old_log;
			throw $e;
		}
		\Kohana::$log = $old_log;

		$log->add(Argument::cetera())->shouldHaveBeenCalled();
	}


}
