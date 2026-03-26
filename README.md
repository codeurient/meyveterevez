# AI Project Preparation System v2.2

## Architecture: Universal Base + Application Profile

This system is **fully application-agnostic**. The core rules, workflows, and standards apply to ANY Laravel project — ecommerce, SaaS, marketplace, CRM, CMS, API platform, or custom business app.

**You don't specify the application type upfront.** When you're ready, fill in `APP_PROFILE.md` (the ONLY file you edit) and tell Claude to generate an app-specific guide. The universal system adapts automatically.

```
┌─────────────────────────────────────────┐
│  Layer 1: UNIVERSAL BASE                │  ← Never edit (works for all projects)
│  CLAUDE.md, AGENTS.md, docs/, rules/    │
├─────────────────────────────────────────┤
│  Layer 2: APP_PROFILE.md                │  ← EDIT THIS (one file, per project)
│  Domain, features, constraints, i18n    │
├─────────────────────────────────────────┤
│  Layer 3: docs/app/*.md                 │  ← Claude GENERATES this for you
│  App-specific guide based on profile    │
└─────────────────────────────────────────┘
```

## Complete File Structure (34 files)

```
project-root/
├── CLAUDE.md                              ← AI constitution (<100 lines, always loaded)
├── AGENTS.md                              ← Cross-tool standard (Cursor, Copilot, Codex)
├── APP_PROFILE.md                         ← SINGLE customization point (fill per project)
│
├── .claude/
│   ├── settings.json                      ← Hooks: Pint + Larastan pre-commit, verify pre-push
│   ├── rules/
│   │   ├── laravel.md                     ← Unconditional: always active Laravel conventions
│   │   ├── ast-index.md                   ← Path-scoped: code search command reference (NEW)
│   │   ├── context-mode.md                ← Unconditional: context window management (NEW)
│   │   ├── api.md                         ← Path-scoped: API controllers + routes
│   │   ├── security.md                    ← Path-scoped: auth, middleware, config
│   │   ├── testing.md                     ← Path-scoped: tests + factories
│   │   ├── frontend.md                    ← Path-scoped: views, JS, CSS
│   │   └── i18n.md                        ← Path-scoped: lang files, locale middleware
│   └── skills/
│       ├── build-test-verify/SKILL.md     ← 11-step verification pipeline skill
│       └── create-feature/SKILL.md        ← Feature scaffolding workflow skill
│
├── .vscode/settings.json                  ← VS Code / Antigravity editor config
│
└── docs/
    ├── persistent_progress_reference.md   ← ⚠ MANDATORY: 30 standards + progress log
    ├── ARCHITECTURE.md                    ← Actions/DTOs/Enums, layers, patterns
    ├── DEVELOPMENT_WORKFLOW.md            ← Outer loop: 7 project phases
    ├── FEATURE_VERIFICATION.md            ← Inner loop: 11 steps per feature
    ├── TESTING.md                         ← Pest v4, architecture tests, mutation testing
    ├── SECURITY.md                        ← OWASP 2025, supply chain, pen testing
    ├── SEO_GEO_AEO.md                    ← Search + AI + answer engine optimization
    ├── PERFORMANCE.md                     ← N+1, cursor pagination, OPcache, PHP-FPM
    ├── DEPLOYMENT.md                      ← Zero-downtime, Docker, Deployer, CI/CD
    ├── STYLE_GUIDE.md                     ← Naming, patterns, Git conventions
    ├── AI_NAVIGATION.md                   ← 3-tool architecture: ast-index + context-mode + SearXNG
    ├── UI_INTERACTION.md                  ← SSR, modals, toasts, input persistence
    ├── RESPONSIVE_DESIGN.md               ← Mobile → tablet → laptop → desktop → TV
    ├── I18N.md                            ← Multi-language: middleware, RTL, API
    ├── LOGGING_MONITORING.md              ← Sentry, health checks, structured logging
    ├── PROMPT_LIBRARY.md                  ← Copy-paste AI prompts
    ├── PHASE_CHECKLIST.md                 ← Quick-reference gate checklists
    ├── SETUP/
    │   ├── README.md                      ← Setup directory guide
    │   └── claude-code-setup.md           ← YOUR FILE (place here)
    ├── RUNBOOKS/
    │   ├── MIGRATIONS.md                  ← DB migration procedures
    │   └── TROUBLESHOOTING.md             ← Common issues + fixes + tool diagnostics
    └── project_notes/
        ├── decisions.md                   ← Architectural Decision Records
        ├── bugs.md                        ← Bug log with root causes
        ├── key_facts.md                   ← Environment, URLs, integrations
        └── issues.md                      ← Work log
```

## Quick Start

### For Any New Project
1. Copy this structure into your Laravel project root
2. Run `ast-index build`
3. Start coding — the universal system is immediately active

### When You Know What You're Building
4. Edit `APP_PROFILE.md` — fill in your domain, features, constraints
5. Tell Claude: *"Based on my APP_PROFILE.md, generate an app-specific guide"*
6. Claude creates `docs/app/your-app.md` tailored to your application type

### Example Conversation
```
You: "I want to build an ecommerce marketplace with multi-vendor support"
Claude: [Fills APP_PROFILE.md with marketplace domain, models, workflows]
Claude: [Generates docs/app/marketplace.md with catalog, cart, commission, vendor guides]
Claude: [Creates appropriate Enums, suggests schema, identifies security concerns]
```

## Two-Loop Development Architecture

### Outer Loop: 7 Project Phases
| # | Phase | Key Gate |
|---|-------|----------|
| 1 | PLAN | Requirements, schema, APP_PROFILE.md filled |
| 2 | SCAFFOLD | `migrate:fresh --seed`, CI green |
| 3 | IMPLEMENT | Tests pass, Larastan clean, coverage ≥ 80% |
| 4 | HARDEN | OWASP 2025 complete, zero vulnerabilities |
| 5 | OPTIMIZE | Lighthouse > 90, zero N+1, CWV green |
| 6 | SEO/GEO/AEO | SEO > 95, Accessibility > 95, i18n tested |
| 7 | DEPLOY | Zero-downtime, monitoring active |

### Inner Loop: 11-Step Feature Verification
Every feature within a phase completes:
Create → Test → Performance → Security → Dedup → Dead code →
Integration → Regression → Docs → Commit → Push

## Key Upgrades from v2.1

- **APP_PROFILE.md**: Single customization point — system is now fully app-agnostic
- **Two-loop architecture**: Outer (project phases) + inner (per-feature verification)
- **11-step verification pipeline**: Dead code, duplication, regression as explicit steps
- **Claude Code Skills**: `build-test-verify` and `create-feature` as installable skills
- **i18n from day one**: Multi-language guide, locale middleware, RTL, API localization
- **Unconditional rules**: `.claude/rules/laravel.md` loads on every interaction
- **Dead code detection**: shipmonk/dead-code-detector integrated into `composer verify`
- **Duplication detection**: PHPCPD + jscpd in verification pipeline
- **`composer verify`**: Single command runs lint → analyse → dead-code → duplication → test
- **persistent_progress_reference.md**: 30 universal standards + living progress log — MANDATORY at every step
- **Database-driven i18n**: Translations in DB, admin-managed, Redis-cached (not file-based)
- **Admin URL security**: Configurable via .env, IP restriction, returns 404 not 403
- **Dynamic XML SEO**: Auto-generated sitemaps, admin SEO manager, `seo_metadata` morphable table
- **Component-based code**: Zero inline scripts, Blade components for all repeated UI
- **Phased implementation**: Never change entire system at once — always break into phases
- **Audit trail**: Immutable `audit_logs` table for every state-changing action
- **Pre-launch scaling patterns**: Score columns, cache warming, vendor diversity, denormalized counters
