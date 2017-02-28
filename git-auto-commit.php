<?php

// Get all branches and current branch
$all_branches = explode(PHP_EOL, shell_exec('git branch'));
 $current_branch=null;
foreach ($all_branches as $k => $branch) {
    if (strpos($branch,'*')!==false)
        $current_branch = trim(str_replace('*', '', $branch));
    $all_branches[$k] = trim(str_replace('*', '', $branch));
}

// Look for user submitted variables
// 1 = commit mesasge (optional)
$message = (isset($argv[1]) && ! empty($argv[1])) ? trim($argv[2]) : 'commit '.$local;


print '--- Starting to commit `' . $local . '` branch...' . PHP_EOL;
print '$ git add . ' . PHP_EOL;
print shell_exec('git add . ');
print '$ git commit -m "'.$message.'"' . PHP_EOL;
print shell_exec('git commit -m "'.$message.'"');
print '$ git push' . PHP_EOL;
print shell_exec('git push ');

print '--- Auto-commit complete...' . PHP_EOL;
