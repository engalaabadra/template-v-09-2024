<?php

use Modules\Review\Entities\Review;
use Modules\Favorite\Entities\Favorite;

/**
 * Get the base URL for the application.
 *
 * @return string
 */
function urlDomain(): string
{
    return 'http://127.0.0.1:8000/';
}

/**
 * Encrypt a string using MD5 hash.
 *
 * @param string $string
 * @return string
 */
function encryptString(string $string): string
{
    return hash('md5', $string);
}

/**
 * Calculate the average rating for a given post.
 *
 * @param int $postId
 * @return float
 */
function avgRatingReview(int $postId): float
{
    $averageRating = Review::where('post_id', $postId)
        ->avg('rating');

    return round($averageRating, 3);
}

/**
 * Check if a post is marked as favorite by the authenticated user.
 *
 * @param int $postId
 * @return bool
 */
function isFav(int $postId): bool
{
    $user = authUser();
    if ($user) {
        return Favorite::where([
            'post_id' => $postId,
            'user_id' => $user->id
        ])->exists();
    }

    return false;
}

/**
 * Convert UTC datetime to the application's timezone.
 *
 * @param string $utc
 * @return string
 */
function setTimeZone(string $utc): string
{
    $dateTime = new DateTime($utc);
    $timeZone = new DateTimeZone(config('app.timezone'));

    $dateTime->setTimezone($timeZone);

    return $dateTime->format('Y-m-d H:i:s');
}


/**
 * Check if the data is numeric or string.
 *
 * @return response
 */
function itemNotFound($data){
    if(is_numeric($data)) return 404;
}

/**
 * Check if the data is numeric or string.
 *
 * @return bool
 */
function isDataMissing($data){
    if(is_numeric($data)) return clientError(4);
    if(is_string($data)) return clientError(0,$data);
}


