# Contributing

All code contributions are welcome! These contribution guidelines will help you
 jump right into contributing to this repository.

## Submitting Code

This repository follows a pull request workflow. All code submitted into
`develop` and `master` must be done through a pull request.

All ongoing development takes place in `develop`. `master` always contains the
 most recently released and versioned code.

Example: `master` is set to version `1.5.1`. All changes for new versions must
 me made through pull requests against `develop`. When `1.5.2` (or `1.6`) is
 ready for release, a pull request will be made against `master` to merge in
 all changes from `develop`.

### `develop` Pull Request Process

1. Ensure your local checkout of the repository is up to date.
1. Check out the `develop` branch.
1. Create a new branch for your work.
1. Make as many changes and commits as necessary within your branch.
1. Submit a pull request to merge your branch into `develop`.

### `master` Pull Request Process

1. Ensure your local checkout of the repository is up to date.
1. Check out the `develop` branch.
1. Create a new branch for your work.
1. Increment version number strings.
1. Update `CHANGELOG.md`, `README.md`, and other files to accurately explain
 changes, new features, and bug fixes being merged in. For items that need more
 explanation, link out to a blog post documenting them in more detail.
1. Perform any necessary build tasks through Grunt.
1. Submit a pull request to merge your branch into `master`.

## Rules & Guidelines

### Creating Pull Requests

Pull requests should have a meaningful titles and descriptions of the changes
 being merged in. This could mean one sentence, or 4 paragraphs. Someone
 reviewing your pull request should be able to easily understand what was added
 or changed, why, and how you fixed it. Use your best judgement.

If one exists, the pull request should link to the GitHub issue (typing # will
 bring up an autocomplete dialogue to search through issues). Also, consider
 linking the pull request to a Trello card with the GitHub Power-Up.

### Deleting Branches

After successfully merging a branch into the `develop` or `master`, the pulled
 branch should be deleted. Only branches with active development, or unmerged
 code should remain in the repository. The person merging the branch and
 closing out the pull request is responsible for doing this.

### Branch Names

Branches can be named anything you want. However, it is very helpful to include
 useful information in branch names, such as:

* GitHub issue numbers.
* Short name of the problem (Ex. adding-thumbnail-support-to-pages).
* Other identifying information.

### Writing Good Code

All pull requests should be peer reviewed by another team member. Please use
 good coding style & best practices.

Except where noted in [our own coding standards repository](https://github.com/bu-ist/coding-standards),
 we follow the [WordPress Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/)
 to the best of our abilities.

Each pull request will automatically be evaluated by [Code Climate](https://codeclimate.com/).
 A Code Climate build will "fail" when new issues are introduced within a pull
 request. While it is not required for your pull request to pass the Code
 Climate build, it is highly encouraged. Our codebase should be consistently
 improving, not regressing.

### Unit Tests

If this repository possesses any unit tests, they are required to pass in order
 for a pull request to be merged.

If you are introducing new functions in your pull request, please do your best
 to include unit tests validating the functionality of newly added functions.