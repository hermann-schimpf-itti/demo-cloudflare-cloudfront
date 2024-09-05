<p style="text-align: center;"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

[![Latest stable version](https://img.shields.io/packagist/v/hds-solutions/laravel?style=flat-square&label=Laravel&color=009664)](https://github.com/hschimpf/laravel/releases/latest)
[![Total Downloads](https://img.shields.io/packagist/dt/hds-solutions/laravel?style=flat-square&label=Downloads&color=878787)](https://packagist.org/packages/hds-solutions/laravel)
[![Required PHP version](https://img.shields.io/packagist/dependency-v/hds-solutions/laravel/php?style=flat-square&label=PHP&color=006496&logo=php&logoColor=white)](https://packagist.org/packages/hds-solutions/laravel)

# Demo Cloudflare > AWS Cloudfront

## Custom Laravel Scaffold

Hey there, fellow developers! This is my custom Laravel scaffold used for my personal projects.

### What's under the Hood?

This fantastic scaffold comes packed with powerful tools and goodies that'll make your development experience a breeze:

- [Bref](https://bref.sh) for effortless deployments to AWS Lambda
    - Seamless integration of [Bref's Laravel Bridge](https://bref.sh/docs/frameworks/laravel.html) with exciting
      features:
        - DynamoDB as the `cache` driver
        - S3 serving as the `filesystem` driver, complete with public and private storage options
        - Supercharged queues with SQS as the `queue` driver
    - With [Bref's Secrets Loader](https://bref.sh/docs/environment/variables#at-runtime) to securely store your App's
      settings outside the repository
    - With a plus of a deploy-ready `serverless.yml` configuration file
- [Laravel Modules](https://github.com/nWidart/laravel-modules) with customized `stubs` for modular awesomeness
- [Inertia.js](https://inertiajs.com/) and [Vue.js](https://vuejs.org/)
  with [SSR](https://inertiajs.com/server-side-rendering) ready configuration and updated `resolve()` flow to also load
  components from modules
- [Laravel DebugBar](https://github.com/barryvdh/laravel-debugbar) to turbocharge your development workflow
- [Pest](https://pestphp.com/) for rock-solid unit testing, complete with an updated `phpunit.xml` configuration file
  that covers your modules too
    - [Pest Laravel Plugin](https://pestphp.com/docs/plugins#laravel)
    - [Laravel DOM Assertions](https://github.com/sinnbeck/laravel-dom-assertions)
    - With added custom assertions: `toHaveDateFormat()`, `toBeSameDay()`, `toHaveUnitTests()`
- [Ziggy](https://github.com/tighten/ziggy) Your magic wand for effortlessly accessing Laravel routes in
  TypeScript/JavaScript
- [Font Awesome v6](https://fontawesome.com) Because everything looks better with icons
- [Tailwind CSS v3](https://tailwindcss.com)

**But wait, there's more! This scaffold just got even mightier with these awesome additions**:

- **Updated GitHub Workflows for Smart Deployment Actions for every environment:**
    - Dev Environment:
        - Any push to the `develop` branch triggers the deployment job
        - Any merged PR to the `develop` branch triggers the deployment job
        - Both cases execute the CI `tests` job before deployment

    - Staging Environment:
        - Pushing to a `release/*` branch triggers the deployment job
        - CI `tests` job executes before the deployment

    - Production Environment:
        - Only successfully merged PRs to the `main` branch trigger the deployment job
        - CI `tests` job executes prior to deployment

- **Credentials and configuration values are managed through GitHub's secrets/variables:**
    - **Secrets** that must be set:
        - `AWS_ACCESS_KEY_ID` Your AWS credentials
        - `AWS_SECRET_ACCESS_KEY` Your AWS credentials
        - `SLS_CERTIFICATE_ARN` ARN of the certificated used for deployments _(must match all environment domains, see
          below)_.
    - **Variables**:
        - `APP_NAME` to customize deployed app's name _(default: 'Laravel')_
        - `BREF_PHP_VERSION` to specify which PHP version of Bref is used
        - `SLS_BASE_DOMAIN` to set the deployment domain
            - `dev` and `staging` deployments have environment prepend to the domain: ex: dev.example.com
            - `production` deployment with use specified domain without any change
        - `SLS_SERVICE` to customize the deployed service name _(default: 'app')_

Your journey to exceptional Laravel development starts here. Get ready to create, innovate, and make your projects shine
brighter than ever before.

# Security Vulnerabilities

If you encounter any security-related issues, please feel free to raise a ticket on the issue tracker.

# Contributing

Contributions are more than welcome! If you come across any issues, have great ideas for new features, or want to make
improvements, please don't hesitate to submit a pull request.

## Contributors

A huge shout-out to the contributors who have made this scaffold possible:

- Don't forget to thank all the amazing folks on
  the [Laravel community](https://github.com/laravel/laravel/graphs/contributors)
- Also, a big thanks to everyone in the [Bref community](https://github.com/brefphp/bref/graphs/contributors)
- All the awesome individuals in the [Pest community](https://github.com/pestphp/pest/graphs/contributors)
- The dedicated members of the [Serverless community](https://github.com/serverless/serverless/graphs/contributors)
- And of course, [Hermann D. Schimpf](https://hds-solutions.net)

# Licence

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
