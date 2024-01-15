<?php
function formatDateTime($dbDateTime) {
    // Create a DateTime object from the database datetime string
    $dateTime = new DateTime($dbDateTime);

    // Format the DateTime as desired (e.g., "M d, Y h:i A" for "Jan 01, 2022 12:30 PM")
    $formattedDateTime = $dateTime->format("M d, Y h:i A");

    return $formattedDateTime;
}
