<?php
// Function to create a ghost commit
function createGhostCommit($repoPath, $commitMessage) {
    $currentDateTime = date('Y-m-d H:i:s');
    $ghostFileName = "ghost_commit_$currentDateTime.txt";
    $ghostFilePath = "$repoPath/$ghostFileName";

    // Create a new empty file
    file_put_contents($ghostFilePath, "This is a ghost commit.\n");

    // Add the file to the index
    shell_exec("cd $repoPath && git add $ghostFilePath");

    // Commit the changes
    shell_exec("cd $repoPath && git commit -m \"$commitMessage\"");

    // Push to remote
    shell_exec("cd $repoPath && git push origin master");

    // Clean up the ghost file
    unlink($ghostFilePath);
}

// Example usage
$repoPath = "";
$commitMessage = "Automated ghost commit" . date('Y-m-d H:i:s');
createGhostCommit($repoPath, $commitMessage);
?>
