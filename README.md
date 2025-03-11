# Morntag Hello Elementor Child Theme

This is a custom child theme based on the Elementor Hello theme, designed for.

## Setup

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/morntag/morntag-hello-elementor.git
    cd [repository directory]
    ```

2.  **Install Composer dependencies:**

    ```bash
    composer install
    ```

## Git Hooks

This repository uses Git hooks to automate certain tasks. To enable these hooks:

1.  **Add Git hooks using Composer:**

    ```bash
    composer cghooks add
    ```

    This command links the hooks defined in the `scripts` folder to your local Git hooks.

## .distignore vs .gitignore

- **.gitignore:** This file specifies intentionally untracked files that Git should ignore. Typically, it includes files that are specific to your local development environment, such as IDE configuration files, temporary files, and sensitive information.
- **.distignore:** This file is used during the theme release process. It specifies files and directories that should be excluded from the ZIP archive created for distribution. This helps to keep the release package clean and small by excluding development-related files.

## Release Process

This repository uses a GitHub Actions workflow to automate the theme release process. When a pull request is merged into the `main` branch, the workflow automatically:

- Extracts the version number from the `style.css` file.
- Creates a ZIP archive of the theme, excluding files specified in `.distignore` (or using default exclusions).
- Creates a new GitHub release with the generated ZIP archive as an asset.

This ensures that a new, packaged version of the theme is created and published automatically with each merge to the `main` branch.
