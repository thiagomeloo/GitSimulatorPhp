# Git Simulator PHP

## Usage
> ⚠️ Use only in fake repositories.

- Add in `composer.json`

  ```json
    "repositories": [
      {
          "type": "vcs",
          "url": "https://github.com/thiagomeloo/GitSimulatorPhp.git"
      }
    ],
    "require": {
      "thiagomeloo/git-simulator-php": "dev-main"
    }
  ```
- Execute `composer install`

- Generate the commits

  ```
    ./vendor/bin/git-simulator-php
  ```

