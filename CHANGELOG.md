# 2.0.0
  - added compile command `conso compile` compile you app to a phar file
  - added Cosno `TestCase` class helper for easy commands testing
  - cleanup commandHelp

# 1.9.0
 - adding verbosity level `-vv --verbose`
 - adding invoke command from `http` (you can now invoke conso from http)
 - adding disable built in commands `$conso->disableBuiltInCommands()`

# 1.8.0
 - adding commands namespace method `namespace(string $namespace)`
 - adding commands group method  `group(string $name)`

# 1.7.0
 - adding flag value support `--flag=value`
 - fix options allow only alpha numeric

# 1.6.2
 - fix register build in commands

# 1.6.1
 - fix help
 - update readme

# 1.6.0
 - fix call command
 - better help function
 - clean up linker

# 1.5.0
  - separate invoking from app
  - clean up commands file
  - bind app to closure commands
  - fix help for closure commands
  - add call command method

# 1.0.1
  - fix app dependency

# 1.0.0
  - new implementation

# 0.2.0 (first release)
  - fix config adding OoFile package
  - fix windows 7 ansi
  - commands location creation
  - fix append additional commands