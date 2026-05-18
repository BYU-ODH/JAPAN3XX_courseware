# JAPAN3XX_courseware

This repository contains the courseware for the Japanese 301, 302, and 322
sites. Each course is built from source data in its own directory and rendered
into static HTML under `generated_html/`.

## Current layout

- `301/` - source XML, build script, and generated site for course 301
- `302/` - source XML, build script, and generated site for course 302
- `322/` - source XML, build script, transcript files, and generated site for
  course 322
- `common/` - shared CSS, icons, HTML fragments, and XML validation support
- `index.html` - simple entry page that links to the generated course sites

## Workflow

1. Edit the course source in the relevant course directory.
2. Rebuild that course by running `python3 build_html.py` from inside the
	course directory.
3. The script writes static output to `generated_html/` and copies shared
	assets from `common/`.
4. If you change XML source files, validate them with `common/validate_xml.py`
	before rebuilding.

Examples:

```bash
cd 301 && uv run build_html.py
cd 302 && uv run build_html.py
cd 322 && uv run build_html.py
```

The generated files are build outputs and should not be edited directly unless
you are intentionally changing the rendered static site.
