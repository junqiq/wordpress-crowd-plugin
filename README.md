# CrowdLogin for wordpress
Contributors: Jun Matsushita
Old Contributors: clifgriffin
Tags: Crowd, authentication, login
Tested on: Wordpress Version 4.9.4 and Crowd Version 3.0.1
Stable tag: 0.2

## About
This plugin allows you to integrate Wordpress with Crowd quickly and easily.
This plugin use the REST API of Crowd Server.
cf. https://docs.atlassian.com/atlassian-crowd/3.0.1/REST/

## Features

### Authentication
  Supports Atlassian Crowd authentication

### Includes two login modes:
  1. Auto Creation Mode(default): Creates Wordpress accounts automatically for any Crowd user.
  2. Manual Mode: Authenticates existing Wordpress usernames against Crowd. This requires you to create all Wordpress accounts manually using the same user names as those in your Crowd directory.

### Includes two security modes:
  1. Low Security Mode(default): If the plugin is unable to authenticate the crowd user, it passes it down the chain to Wordpress.
  2. High Security Mode: If the plugin is unable to authenticate the crowd user, the authenticate fail.

### Mapping CrowdGroup to WordpressRole
  - This plugin mapping the groups of crowd with the roles of wordpress.
  - The group name is need to define the name which connected the application name set in crowd and the role name of wordpress.
  - If the user joined some groups, the user is mapping to the role of first order in role_list. But I think that it is better that the user enters into one group.

  e.g.
  - Application name: wp-test
  - Wordpress roles:  administrator / editor / subscriber
  - CrowdGroup name:
    - wp-test-administrator -> mapping to administrator role.
    - wp-test-editor        -> mapping to editor role.
    - wp-test-subscriber    -> mapping to subscriber role.

## Installation

1. Create an application in Crowd as you will need the application name,
   password, and URL to the Crowd server to setup this plugin.
2. Use the WordPress plugin directory to install the plugin or upload the
   directory "crowd-login" to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Immediately update the settings to those that best match your environment
   by going to Settings -> Crowd Login
5. If you don't get the settings right the first time, don't fret! Just use
   your Wordpress credentials, they will always work in low security mode.
6. Once you have the settings correct, you can change the security mode to
   High Security (if you so desire).

## Changelog
**Version 0.1**
* Original release by clifgriffin.

**Version 0.2**
* Using Crowd REST API.
* Create the function of mappings Crowd-group to Wordpress-Role.