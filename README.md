# NeuroQR

A seven-page marketing website built with HTML, vanilla JavaScript, CSS, and locally compiled Tailwind CSS. No frontend framework, CSS CDN, external fonts, analytics, or application backend is required.

## Preview

The generated HTML and CSS are included. From this directory:

```powershell
python -m http.server 4173 --bind 127.0.0.1
```

Open **http://127.0.0.1:4173**. An editor's static server also works. Relative paths allow `index.html` to be opened directly for a basic preview.

## Pages

- `/` — company positioning, philosophy, product overview, pricing, roadmap
- `/products/` — current product and broader product philosophy
- `/products/intelligent-qr/` — customer/admin experiences and AI example
- `/services/` — AI, software, security, and business consulting
- `/pricing/` — Core ($7) and AI ($11), setup offer, FAQs
- `/company/` — mission, principles, and founders
- `/contact/` — contact and prefilled trial enquiries

## Editing and building

Edit page content and shared sections in `scripts/build.mjs`. HTML files are generated outputs. Edit custom styles in `styles/input.css` and interactions in `assets/site.js`.

For the standard build workflow, install Node.js 20 or newer and run:

```sh
npm install
npm run build
npm run dev
```

The [Tailwind CLI](https://tailwindcss.com/docs/installation/tailwind-cli) is pinned to 4.1.13. This workspace also includes an ignored standalone compiler, so CSS can be rebuilt without Node:

```powershell
.\.tools\tailwindcss.exe -i styles/input.css -o assets/styles.css --minify
```

Run `node scripts/build.mjs` to regenerate HTML only. There is no separate bundle: HTML, compiled CSS, JavaScript, and the logo are the production files.

## Business configuration

`assets/config.js` contains:

- `contactEmail`: configured as `neuroqrllc@gmail.com`.
- `contactEndpoint`: optional HTTPS JSON POST endpoint. If supplied, the form sends `{name, business, email, phone, interest, message}` and treats HTTP 2xx as success. The endpoint must support the site's origin, validate submissions, and handle delivery.
- `loginUrl`: empty because no verified product login destination was supplied. Login shows an accessible help dialog until configured.
- `siteUrl`: set to the final HTTPS origin to enable canonical and Open Graph URL tags. No production domain is invented.

**Contact opens the visitor's email application with a draft.** It does not silently send email, register an account, or activate a trial. Visitors review and send the email themselves. A text download provides a fallback when no email app is available. The direct email address is also displayed. No form content is saved in browser storage.

The assistant example uses fixed, labeled sample catalogue responses; it is not a live AI integration. The original supplied logo is preserved. Optional legal pages and unverified social links are omitted.

## Verification

```sh
npm run check
npm test
```

Tests use Playwright with installed Microsoft Edge. Set `BROWSER_CHANNEL=chrome` to use installed Chrome. Tests start their own server on port 4174 and save desktop/mobile screenshots to ignored `.qa/`.

Checks cover seven pages at 1440, 768, 390, and 320 pixels, internal links, image loading, unique metadata, pricing, menus and dialogs, FAQs, trial prefill, validation, enquiry download, sample responses, keyboard access, and reduced motion. They do not send messages or open an email application.

## Static hosting

Upload `index.html`, `assets/`, `products/`, `services/`, `pricing/`, `company/`, and `contact/` to any static host that serves directory `index.html` files. Exclude `.tools/`, `.qa/`, `node_modules/`, the brief, and development scripts. Set the verified public origin and login URL before launch. The local preview server is for development.
