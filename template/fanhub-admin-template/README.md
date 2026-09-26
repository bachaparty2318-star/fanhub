# Fan Hub Plus — Static Admin UI Handoff

Open `index.html` for the static preview. No sample/fake database records are rendered. Empty states demonstrate how each area behaves before data exists.

## Backend mapping already reflected in UI
Base: `/admin/api`
- `GET auth/me`, `POST auth/logout`, `PUT auth/password`
- `GET dashboard`, `GET activity`, `GET ratings`
- CRUD resources: `categories`, `tags`, `content`, `media`, `characters`, `articles`, `article-images`, `article-timeline-events`, `merchandise`, `merchandise-images`, `events`
- `users`, `submissions`, `feedback`

`assets/js/admin.js` contains `API_BASE`, route/resource definitions, form schemas and fetch helpers. Codex can convert this shell to Blade/PHP while preserving the design and replacing the static hash router with Laravel routes or components.

## Design notes
- Structure intentionally follows the supplied reference: black top navigation, compact expandable left rail, central pipeline workspace, statistic tiles, right event panel, and floating quick-add bar.
- Accent tokens use a vivid yellow-green interpretation of the requested 13-0663 TSX / 20-0199 TPM direction. If you have exact licensed Pantone/TCX digital values, replace `--brand` and `--accent` in `assets/css/admin.css`.
- Responsive layouts included for tablet/mobile.
