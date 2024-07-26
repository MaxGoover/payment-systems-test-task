<?php

declare(strict_types=1);

namespace Tests\Fixtures;

final class EmailFixture
{
    public int $email_status_id;
    public int $user_id;
    public string $address;
    public string $theme;
    public string $content;
    public string $created_at;
    public string $updated_at;

    public static function create(): self
    {
        $email = new self();
        $email->email_status_id = 1;
        $email->user_id = 1;
        $email->address = 'maxgoover@gmail.com';
        $email->theme = 'test theme';
        $email->content = 'test content';
        $email->created_at = date('Y-m-d H:i:s');
        return $email;
    }
}
