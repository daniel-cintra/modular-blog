<?php

it('can run modular:blog-migrate command', function () {
    $this->artisan('modular:blog-migrate')
        ->expectsOutput('Modular Blog migrated successfully.')
        ->assertExitCode(0);
});
