<?php

// Get all branches
$all_branches = explode(PHP_EOL, shell_exec('git branch'));
foreach ($all_branches as $k => $branch) {
    $all_branches[$k] = trim(str_replace('*', '', $branch));
}


// Look for user submitted variables
// 1 = branches to merge commit and merge from
// 2 = branch to use to merge to
// 3 = commit mesasge (optional)
$local   = (isset($argv[1]) && ! empty($argv[1])) ? trim($argv[1]) : '';
$master  = (isset($argv[2]) && ! empty($argv[2])) ? trim($argv[2]) : 'master';
$message = (isset($argv[3]) && ! empty($argv[3])) ? trim($argv[3]) : 'commit '.$local.' to '.$master;

// Figure if local branch used for merging exists
if (! in_array($local, $all_branches)) {
    print 'Fatal: The branch `' . $local . '` to be used for merging from does not exist.' . PHP_EOL;
    exit(0);
}

// Figure if master branch used for merging exists
if (! in_array($master, $all_branches)) {
    print 'Fatal: The branch `' . $master . '` to be used for merging to does not exist.' . PHP_EOL;
    exit(0);
}

// Figure if local branch used for merging is valid
if ($local == '' || $local == $master) {
    print 'Fatal: The branch `' . $local . '` is not valid.' . PHP_EOL;
    exit(0);
}

print '--- Starting to commit `' . $local . '` branch...' . PHP_EOL;
print '$ git checkout '.$local . PHP_EOL;
$output = shell_exec('git checkout '.$local);
print $output;
if (strstr(strtolower($output), 'error')) {
    print 'There were errors checking out `' . $local . '` branch. Please fix these errors in current brach' . PHP_EOL;
    exit(0);
}
print '$ git add . ' . PHP_EOL;
print shell_exec('git add . ');
print '$ git commit -m "'.$message.'"' . PHP_EOL;
print shell_exec('git commit -m "'.$message.'"');
print '$ git push' . PHP_EOL;
print shell_exec('git push ');


print '--- Starting to merge form `' . $local . '` branch to '.$master.' branch...' . PHP_EOL;

print '$ git checkout ' . $master . PHP_EOL;
print shell_exec('git checkout ' . $master);
print '$ git pull' . PHP_EOL;
print shell_exec('git pull');
print '$ git merge ' . $local . PHP_EOL;
$output = shell_exec('git merge ' . $local);
print $output . PHP_EOL;

if (strstr($output, 'CONFLICT')) {
    print 'There were errors merging `' . $local . '` into `' . $master . '`. Please fix these conflicts and then commit your chenges to '.$master.' branch.' . PHP_EOL;
    exit(0);
}


print '$ git push' . PHP_EOL;
print shell_exec('git push ');

print '$ git pull origin '.$master . PHP_EOL;
print shell_exec('git pull origin '.$master);

print '--- Starting to pull from `' . $master . '` branch to '.$local.' branch...' . PHP_EOL;

print '$ git checkout '.$local . PHP_EOL;
$output = shell_exec('git checkout '.$local);
print '$ git pull origin master' . PHP_EOL;
print shell_exec('git pull origin master');

print '--- Auto-merge complete...' . PHP_EOL;
