# WP-CLI Readme Command

Validate readme.txt of themes and plugins.

### Update classes from WordPress Meta

```bash
# Check out SVN repository
svn co http://meta.svn.wordpress.org/sites/trunk/wordpress.org/public_html/wp-content/plugins/plugin-directory/

# Copy classes
cat <<"EOT" | xargs -I % -- cp --parents % /path/to/wp-cli-readme-command/src/
libs/michelf-php-markdown-1.6.0/Michelf/MarkdownExtra.inc.php
libs/michelf-php-markdown-1.6.0/Michelf/MarkdownInterface.php
libs/michelf-php-markdown-1.6.0/Michelf/Markdown.php
libs/michelf-php-markdown-1.6.0/Michelf/MarkdownExtra.php
class-markdown.php
readme/class-parser.php
readme/class-validator.php
EOT

# Comment out sanitize_contributors() call
sed -i -e 's#^.*this->sanitize_contributors.*#//&#' /path/to/wp-cli-readme-command/src/readme/class-parser.php
```
