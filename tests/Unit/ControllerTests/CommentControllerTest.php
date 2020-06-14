<?php

namespace Tests\Unit\ControllerTests;

use App\Enums\UserRole;
use App\Http\Controllers\CommentController;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CommentControllerTest extends TestCase {

    private static $commentController;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$commentController = resolve(CommentController::class);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function testCommentControllerShouldNotBeNull() {
        self::assertNotNull(self::$commentController);
    }

    public function testCommentControllerShouldBeOfProperInstance() {
        self::assertInstanceOf(CommentController::class, self::$commentController);
    }

    public function testCommentControllerShouldHaveProperMiddleware() {
        $middleware = self::$commentController->getMiddleware();
        $roleMiddleware = $middleware[0]['middleware'];
        self::assertEquals('role:' . UserRole::Regular, $roleMiddleware);
    }
}
