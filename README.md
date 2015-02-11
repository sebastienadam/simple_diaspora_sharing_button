# Simple diaspora* sharing button

The purpose of these scripts is to add a simple sharing button on your
website for [diaspora*](https://diasporafoundation.org/) social network. If you want a more complex button,
you can use the [Advanced Sharer for diaspora*](http://sharetodiaspora.github.io/about/).

## Installation

Copy the files under `php` on the public part of your website.

## Usage

Make a link to `selectpod.php` file just like this:

```
<a href="[path_to_directory]/selectpod.php?url=[source_page_url]&title=[source_page_url]&notes=[optional_notes]">diaspora*</a>
```

The (optionals) parameters of the script are:

 * `url`: the url of the page to share.
 * `title`: the title of the page to share.
 * `notes`: an optional note.

The `diaspodlist.php` is a script that retrieve diaspora* pods list
from the site [Diaspora Pod Uptime Status](http://podupti.me/) in JSON
format.
