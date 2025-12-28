# ProfileController

---

## Propósito / Purpose

### Español
El `ProfileController` gestiona la **configuración del perfil del usuario autenticado**, permitiendo la visualización, actualización de información personal y la eliminación segura de la cuenta.  
Está enfocado en **seguridad**, **validación estricta** y **protección de credenciales**.

### English
The `ProfileController` manages the **authenticated user's profile settings**, allowing profile viewing, personal information updates, and secure account deletion.  
It is focused on **security**, **strict validation**, and **credential protection**.

---

## Responsabilidades / Responsibilities

### Español
- Mostrar el formulario de edición de perfil
- Actualizar nombre, correo electrónico y contraseña
- Verificar la contraseña actual antes de aplicar cambios
- Encriptar contraseñas nuevas
- Eliminar cuentas de forma segura
- Cerrar sesión y limpiar sesión al eliminar la cuenta

### English
- Display the profile edit form
- Update name, email, and password
- Verify current password before applying changes
- Encrypt new passwords
- Securely delete user accounts
- Log out and invalidate session on account deletion

---

## Métodos del Controlador / Controller Methods

| Método | HTTP | Ruta | Descripción |
|------|------|------|-------------|
| edit | GET | /profile | Muestra formulario de perfil |
| update | PUT/PATCH | /profile | Actualiza datos del usuario |
| destroy | DELETE | /profile | Elimina la cuenta del usuario |

---

## Detalle de Métodos / Method Details

---

### `edit(Request $request): View`

**ES:**  
Devuelve la vista del perfil del usuario autenticado, enviando la información del usuario actual.

**EN:**  
Returns the authenticated user's profile view, passing the current user data.

---

### `update(Request $request)`

**ES:**  
Actualiza la información del perfil del usuario autenticado.

#### Funcionalidades clave:
- Obtiene el usuario autenticado por ID
- Valida:
  - Nombre
  - Correo único (ignorando el propio usuario)
  - Contraseña actual
  - Nueva contraseña (opcional)
- Verifica que la contraseña actual sea correcta
- Encripta la nueva contraseña si se proporciona
- Evita sobrescribir la contraseña si no se envía
- Actualiza los datos del usuario

**EN:**  
Updates the authenticated user's profile information.

#### Key features:
- Retrieves authenticated user by ID
- Validates:
  - Name
  - Unique email (excluding current user)
  - Current password
  - Optional new password
- Verifies current password correctness
- Hashes the new password if provided
- Prevents password overwrite if not submitted
- Updates user data

---

### `destroy(Request $request): RedirectResponse`

**ES:**  
Elimina la cuenta del usuario de forma segura.

#### Proceso:
1. Valida la contraseña actual
2. Cierra la sesión del usuario
3. Elimina el registro del usuario
4. Invalida la sesión
5. Regenera el token CSRF
6. Redirige a la página principal

**EN:**  
Securely deletes the user account.

#### Flow:
1. Validates current password
2. Logs out the user
3. Deletes the user record
4. Invalidates the session
5. Regenerates CSRF token
6. Redirects to the home page

---

## Seguridad / Security

### Español
- Autenticación obligatoria
- Verificación de contraseña actual antes de cambios críticos
- Uso de `Hash` para encriptación
- Limpieza de sesión tras eliminación de cuenta
- Protección contra duplicidad de correos

### English
- Mandatory authentication
- Current password verification for critical changes
- Use of `Hash` for encryption
- Session cleanup after account deletion
- Protection against duplicate emails

---

## Dependencias / Dependencies

- `App\Models\User`
- `Illuminate\Support\Facades\Auth`
- `Illuminate\Support\Facades\Hash`
- `Illuminate\Validation\Rules\Password`

---

## Consideraciones de Escalabilidad / Scalability Notes

### Español
- Puede integrarse con un sistema de auditoría de cambios de perfil
- Puede extenderse para manejo de avatar o MFA
- Validaciones listas para internacionalización

### English
- Can be integrated with a profile audit logging system
- Ready to extend for avatar handling or MFA
- Validation rules prepared for internationalization

---

## 📎 Notas Finales / Final Notes

Este controlador sigue buenas prácticas de Laravel para **seguridad de cuentas**, siendo una pieza clave para la confianza del usuario final.

This controller follows Laravel best practices for **account security**, making it a key component for end-user trust.
