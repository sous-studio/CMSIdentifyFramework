# CMSIdentifyFramework
CMS Identify Framework (fingerprinting for web servers)

Code is unique except function http_parse_headers, taken from http://stackoverflow.com/a/6368623

# Usage

php cmsidentify.php <urlbase>

eg.
php cmsidentify.php http://wordpress.org (without trailing slash)

# Rules

./config directory contains JSON rules. Rules are variable, with common properties such as:

controller - name of controller (eg. file_scan for file_scan.php)
file_name  - path to request beyond base URL
software   - name of software (see versions.json)
message    - default message to display if we have a hit

