# Generate HTML

The file `lessons.tsv` was automatically extracted from `302_orig_utf8/`, using
the python script in `scripts/extract_content.py`. This script and the
original source are kept for historical reasons, but moving forward,
`lessons.tsv` is to be treated as the source file for any editing.

## Generate the website

Run the following command in this directory:

```bash
python3 scripts/build_html.py
```

This will update the source files in `generated_html/`.
