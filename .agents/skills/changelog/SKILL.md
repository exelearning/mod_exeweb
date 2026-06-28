---

name: changelog
description: Generate a draft CHANGELOG entry for the next release from merged GitHub pull requests. Asks the user for the target version before starting.
----------------------------------------------------------------------------------------------------------------------------------------------------------

# Skill: Generate CHANGELOG draft

> **This skill produces a working draft, not a finished changelog.** The output is a starting point to make the task easier — the maintainer must review, edit and refine every entry before committing.

Generate a draft entry for `public/CHANGELOG.md` based on the pull requests merged since the last published release, then insert it at the top of the file.

---

## 0. Ask for the target version

**Before doing anything else**, ask the user:

> What will the version number and type be for this release?
> Examples: `v4.0.0-rc2`, `v4.0.1`, `v4.1.0-beta1`

Wait for the answer. Use that value verbatim for the heading — do not infer or calculate it from the existing CHANGELOG.

The release date is **today's date** in `yyyy-mm-dd` format.

---

## 1. Find the latest published release on GitHub

Fetch the latest release to get the cut-off timestamp:

```sh
gh release view --repo exelearning/exelearning --json tagName,publishedAt
```

Record:

* **`tagName`** — the git tag of the last release (e.g. `v4.0.0-rc1`).
* **`publishedAt`** — the ISO timestamp used to filter merged PRs.

---

## 2. Collect all merged PRs since the last release

```sh
gh pr list \
  --repo exelearning/exelearning \
  --state merged \
  --search "merged:>YYYY-MM-DDTHH:MM:SSZ" \
  --json number,title,body,labels,mergedAt \
  --limit 200
```

> Replace the timestamp with the `publishedAt` value from step 1.

For each PR, read:

* **`title`** — the PR headline.
* **`body`** — the **full description**. This is the primary source; many PRs bundle several unrelated changes under a single title.
* **`labels`** — useful classification hints.

If a PR body references issues with `Closes #NNN` or `Fixes #NNN`, fetch them too:

```sh
gh issue view NNN --repo exelearning/exelearning --json title,body
```

---

## 3. Write the entries

Follow the **exact style** of the existing changelog entries in `public/CHANGELOG.md`:

### Style rules

* **One sentence per bullet.** Start with a capital letter; no trailing full stop.
* **Lead with the subject area** for component-specific entries:
  `TinyMCE: …`, `Sort iDevice: …`, `File Manager: …`, `Admin panel: …`
* Describe the **outcome for users**, not the implementation:

  * ✅ `Sort iDevice: exercises with identical cards are now correctly validated`
  * ❌ `Fixed a bug in the validation logic of SortIdevice.js`
* **Avoid technical jargon** unless already used in the existing changelog (e.g. `blob:`, `asset://`, `SCORM`).
* **Dependency upgrades:** `package-name: OLD → NEW` (lowercase, `→`, no extra words).
* **Group related items together** (all TinyMCE entries together, all iDevice entries together, etc.).

### What NOT to include

* Duplicate entries for the same fix.
* Multiple "Updated X translation" lines — merge into one: `Updated [Language] ([CODE]) translation`.
* Dependency-only PRs with no user-visible effect may be grouped into one bullet if there are many minor bumps.
* Merge commits and version-bump-only PRs.
* Purely internal changes (CI tweaks, test additions, linting) unless significant.

---

## 4. Assemble the block

```markdown
## vX.Y.Z-type – YYYY-MM-DD

- …

---
```

---

## 5. Insert into `public/CHANGELOG.md`

Insert the new block immediately after the `# CHANGELOG` heading, before the previous version's `## v…` entry.

```markdown
# CHANGELOG

## vX.Y.Z-type – YYYY-MM-DD      ← new draft block
…
---

## v4.0.0-rc1 – 2026-04-07       ← previous block, unchanged
…
```

Do **not** modify any existing content below the insertion point.

---

## 6. Remind the user this is a draft

After inserting the block, tell the user:

> ⚠️ This is a draft. Please review every entry before committing:
>
> * Check that descriptions are accurate and clear for end users.
> * Merge or remove redundant entries.
> * Add anything the PRs may not have described explicitly.

---

## Reference: existing entry style

```markdown
## v4.0.1 – 2026-06-09

- Show the eXeLearning "Edit" button on the activity view when "Display" is set to "In pop-up", "Open" or "New window".
- Remove the legacy "In frame" display option and migrate existing activities to "Embed" during upgrade.
- Fix embedded editor version detection in release packages so the correct eXeLearning version is reported.
- Improve accessibility by updating embedded content frame titles dynamically based on the activity and page title.
- Exclude development files from release packages.
- Update the README to clarify Moodle compatibility, editor modes and support information.
- Automatically install and configure the embedded editor in Playground environments.
```
