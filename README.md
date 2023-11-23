# Mantis plugin FAQ 2.02

**Author**: Cas Nuy \
**Based upon**: FAQ by pbia-at-engineering.com \
**Website**: <http://www.nuy.info> \\
**Mail**:  Cas-at-Nuy.info \
**Copyright**: GPL\

## Description

_This plugin only for MantisBT  2.x.x. For version for MantisBT 1.x.x download an earlier release Thank you._

This plugin enables a FAQ option on the main menu.
The FAQ can be searched in a number of ways.
Each FAQ can be connected site wide or to a specific project.
In addition a link can be added to the “bug view pages” such that an issue can be promoted to a FAQ.
Rights can be set who is allowed to do this.

## Installation

### Part 1

Creating the table should be automatic, if not, follow this.
Create table in the mantis database like:

```sql
CREATE TABLE XXXXXXXXX (
id int unsigned zerofill NOT NULL auto_increment,
project_id int unsigned zerofill NOT NULL,
poster_id int unsigned zerofill NOT NULL,
date_posted datetime NOT NULL,
last_modified datetime NOT NULL,
question varchar(255) NOT NULL,
answere text NOT NULL,
view_access int NOT NULL DEFAULT ‘10’,
PRIMARY KEY (id),
KEY id (id),
KEY headline (question),
KEY project_id (project_id),
KEY date_posted (date_posted)
);
```

**XXXXXXXXX**  needs to be formatted as ```DB-prefix + '_plugin_faq_results_table'```

### Part 2

Copy the plugin into the plugins directory of your mantis installation.
Log on to mantis with Admin right
Go to Manage
Select Manage Plugins
Install FAQ 2.02
Configure plugin by clicking on the name after install.

Default values are:
Store FAQ project-wise
Enable Promotion of issues to FAQ
Permission level for this action is Developer.
View FAQ in standard Mantis window (opposite new window)
FAQ are open to all (opposite access-level check)
View threshold  is Viewer

## Change log

0.91 Initial release
0.92 Added automatic creation of table
 Included All project-FAQ with project-specific FAQ
 Added option to open FAQ in new window
 Added option to set access level on FAQ
0.95 Used the default EVENT_MENU_ISSUE
1.01 Final release for Mantis 1,x
2.01 Intial version for Mantis 2.x
2.02 Bugfixes for version 2.01
