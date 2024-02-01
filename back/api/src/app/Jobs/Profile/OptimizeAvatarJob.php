<?php

namespace App\Jobs\Profile;

use App\Services\Profile\AvatarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OptimizeAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $user_id)
    {
        // Какой сервер соединения использовать
        // Я разберусь - тчо бы уходило в нужное нам соединение
        // $this->onConnection("avatars.jobs");

        // В какой очереди будут обрабатываться задачи по аватарам
        $this->onQueue(env("REDIS_AVATARS_QUEUE", "avatars.jobs"));

        \Laravel\Prompts\info("build job");
    }
/*
    // Укажите, какую очередь использовать
    public function queue($queue)
    {
        return $queue->connection('avatars.jobs');
    }

    // Укажите, какое соединение использовать
    public function connection($connection)
    {
        return $connection->connection('avatars.jobs');
    }
*/
    /**
     * Execute the job.
     */
    public function handle(AvatarService $avatarService): void
    {
        \Laravel\Prompts\info("handle job");
        $avatarService->optimizeAvatar($this->user_id);
    }
}
