<?php

/* Function to fetch a random quote from the quotable API

API Documentation: https://api.quotable.io/random

*/
function getRandomQuote() {
    $url = 'https://api.quotable.io/random';
    $response = file_get_contents($url);
    $quoteData = json_decode($response, true);
    return $quoteData['content'] . ' - ' . $quoteData['author'];
}

/* Function to update an existing file in the repository

1. Fetch a random quote
2. Generate new content with the quote and current date/time
3. Update the content of the existing file
4. Add the file to the index
5. Commit the changes
6. Ensure the main branch exists and track the remote origin/main
7. Push to remote


*/
function updateExistingFile($repoPath) {
    // Fetch a random quote
    $randomQuote = getRandomQuote();

    // Generate new content
    $currentDateTime = date('Y-m-d H:i:s');
    $newContent = "Last updated: $currentDateTime\nRandom Quote: $randomQuote";

    $files = glob("$repoPath/amd7.md");
    if (!empty($files)) {
        $fileToUpdate = $files[0];

        // Update the content of the existing file
        file_put_contents($fileToUpdate, $newContent);

        // Add the file to the index
        shell_exec("cd $repoPath && git add $fileToUpdate");

        // Commit the changes
        $commitMessage = "Updated file: $fileToUpdate";
        shell_exec("cd $repoPath && git commit -m \"$commitMessage\"");

        // Ensure the master branch exists and track the remote origin/master
        shell_exec("cd $repoPath && git checkout -B main");
        shell_exec("cd $repoPath && git branch --set-upstream-to=origin/main main");

        // Push to remote
        shell_exec("cd $repoPath && git push origin main --force");
    } else {
        echo "README.md not found in the repository.";
    }
}

$repoPath = "C:\\Users\\IamJohnDev\\Desktop\\IamGhost";

while (true) {
    updateExistingFile($repoPath);
    sleep(30); // Sleep for 2 minutes before the next update
}

?>