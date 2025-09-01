---
description: Localization & Multi-language Rules
auto_execution_mode: 1
---

# Localization & Multi-language Rules

<locale_setup>

- Idiomas soportados: inglés (en) como default, español (es)
- Estructura: lang/en/, lang/es/ para traducciones de sistema
- Base de datos: user_settings table para preferencias por usuario
- Middleware: DetectUserLocale para setear idioma por usuario
- Fallback: inglés siempre como idioma de respaldo
  </locale_setup>

<translation_patterns>

- Usar \_\_('key') para traducciones simples
- Usar trans_choice() para pluralización
- Organizaciones por archivos: auth.php, validation.php, etc.
- Keys descriptivos: 'auth.login.title' no 'login_title'
- Pasar parámetros: \_\_('welcome.message', ['name' => $user->name])
- Usar JSON translations para strings dinámicos del frontend
  </translation_patterns>

<frontend_localization>

- Usar @lang() en Blade templates
- Implementar useLang() hook para React components
- Compartir translations via Inertia::share()
- Usar route() helper considerando locale en URLs
- Implementar language switcher component
- Cache translations en frontend para performance
  </frontend_localization>

<user_preferences>

- Campo locale en users table (nullable, default null)
- Middleware ejecutar antes de auth middleware
- Permitir cambio de idioma sin recargar página
- Persistir preferencia en base de datos al cambiar
- Considerar timezone junto con locale
- Implementar API endpoint para actualizar preferencias
  </user_preferences>

<seo_considerations>

- URLs con prefijo de idioma opcional: /en/posts, /es/posts
- Meta tags hreflang para SEO multiidioma
- Sitemap XML por idioma
- Consistent URL structure entre idiomas
- Proper canonical URLs
- Schema.org markup con idioma correcto
  </seo_considerations>
