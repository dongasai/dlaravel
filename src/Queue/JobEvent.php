<?php

namespace DLaravel\Queue;

use DLaravel\Helper\Logger;
use DLaravel\Model\JobRun;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobPopped;
use Illuminate\Queue\Events\JobPopping;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Queue\Events\JobQueueing;
use Illuminate\Queue\Events\JobReleasedAfterException;
use Illuminate\Queue\Events\JobRetryRequested;
use Illuminate\Events\Dispatcher;

class JobEvent
{

    /**
     * 作业异常
     * @param JobExceptionOccurred $exceptionOccurred
     * @return void
     */
    public function jobExceptionOccurred(JobExceptionOccurred $exceptionOccurred)
    {
        Logger::info('JobEvent', 'jobExceptionOccurred');

    }

    /**
     * 队列失败
     *
     * @param JobFailed $jobFailed
     * @return void
     */
    public function jobFailed(JobFailed $jobFailed)
    {
        Logger::info('JobEvent', 'jobFailed');
    }

    /**
     * 作业弹出
     * @param JobPopped $jobPopped
     * @return void
     */
    public function jobPopped(JobPopped $jobPopped)
    {
        Logger::info('JobEvent', 'jobPopped');

    }


    public function jobPopping(JobPopping $jobPopping)
    {
        Logger::info('JobEvent', 'JobPopping');

    }

    /**
     * 任务运行完成
     * @param JobProcessed $jobProcessed
     * @return void
     */
    public function jobProcessed(JobProcessed $jobProcessed)
    {
        dump($jobProcessed);
        Logger::info('JobEvent', 'JobProcessed');
        $this->add_log('jobProcessed',$jobProcessed->job->getQueue(),$jobProcessed->job->getName(),json_encode($jobProcessed->job->payload()),'');

    }


    /**
     * 队列已排队
     *
     * @param JobQueued $jobQueued
     * @return void
     */
    public function jobQueued(JobQueued $jobQueued)
    {
        if($jobQueued->job instanceof ShouldQueue){
            $this->add_log(
                'jobQueued',
                $jobQueued->job->queue,
                get_class( $jobQueued->job),
                json_encode($jobQueued->job));
        }

        Logger::info('JobEvent', 'jobQueued');
    }


    /**
     * 队列 调度中
     * @param JobQueueing $jobQueueing
     * @return void
     */
    public function jobQueueing(JobQueueing $jobQueueing)
    {

        Logger::info('JobEvent', 'jobQueueing');
    }


    /**
     * 队列在错误后重新发布
     * @param JobReleasedAfterException $jobReleasedAfterException
     * @return void
     */
    public function jobReleasedAfterException(JobReleasedAfterException $jobReleasedAfterException)
    {
        $this->add_log('jobReleasedAfterException',$jobReleasedAfterException->job);
        Logger::info('JobEvent', 'jobReleasedAfterException');

    }

    /**
     * 队列重新请求
     * @param JobRetryRequested $jobRetryRequested
     * @return void
     */
    public function jobRetryRequested(JobRetryRequested $jobRetryRequested)
    {

        Logger::info('JobEvent', 'JobRetryRequested');
    }


    /**
     * 为订阅者注册监听器。
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            JobQueued::class                 => 'jobQueued',
            jobPopped::class                 => 'jobPopped',
            JobPopping::class                => 'jobPopping',
            jobFailed::class                 => 'jobFailed',
            jobProcessed::class              => 'jobProcessed',
            JobQueueing::class               => 'jobQueueing',
            JobReleasedAfterException::class => 'jobReleasedAfterException',
            JobRetryRequested::class         => 'jobRetryRequested',
            JobExceptionOccurred::class      => 'jobExceptionOccurred',
        ];
    }



}
