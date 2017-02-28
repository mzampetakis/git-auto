# git-auto
PHP scripts to automate git commit &amp; git commit with merge

# git-auto-commit.php

- usage: php git-auto-commit.php [message]
- if message is not set, set message='commit %branch%'

Adds all files, commits and pushes to current branch

# git-auto-merge.php

- usage: php git-auto-merge.php local_banch merge_branch [message]
- local_banch: branch to commit and merge from
- merge_branch: branch to merge to
- if message is not set, set message='commit %local_banch% to %merge_branch%'

Adds all files, commits and pushes to current local_banch. Then checkouts to merge_branch, pulls amd merges from local_banch. Finnally checkouts to local_banch

# Add aliases

You can edit your ~/.bash_aliases and add aliases like this

alias gac='php /path/to/git-auto-commit.php'

alias gam='php /path/to/git-auto-merge.php'

and instead of "php git-auto-commit.php" use "gac"

and instead of "php git-auto-merge.php" use "gam"

