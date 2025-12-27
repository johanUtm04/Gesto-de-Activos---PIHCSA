# ¿De que se trata?

Desarrolle una solución en **Laravel + AdminLTE** para el control, registro y administración de activos de TI (equipos, componentes y periféricos) mediante un **wizard paso a paso**, con enfoque en buena UX, claridad visual y mantenibilidad.

<div style="display: flex; justify-content: center; align-items: center; gap: 25px;">
<table align="center" border="0">
  <tr>
    <td align="center" valign="center">
      <img src="/public/vendor/adminlte/dist/img/logohd.png" width="150" alt="Logo">
    </td>
    <td align="center" valign="center">
      <img src="/public/vendor/adminlte/dist/img/laravel.png" width="150" alt="Laravel">
    </td>
    <td align="center" valign="center">
      <img src="/public/vendor/adminlte/dist/img/mysql.png" width="150" alt="MySQL">
    </td>
    <td align="center" valign="center">
      <img src="/public/vendor/adminlte/dist/img/php.png" width="150" alt="PHP">
    </td>
  </tr>
</table>

---

## Tecnologías utilizadas

* **Laravel** (Backend / MVC)
* **Blade** (Vistas)
* **AdminLTE 3** (UI / Dashboard)
* **Bootstrap 4** (Estilos base)
* **jQuery** (Interacciones UI)
* **MySQL** (Base de datos)

---

## Funcionalidad principal

### Registro de Activos TI

El registro de un activo se realiza mediante un **Wizard guiado**, dividido en pasos claros:

1. **Datos base del equipo**
2. **Ubicación**
3. **Monitor(es)** *(opcional)*
4. **Disco(s) duro(s)** *(opcional)*
5. **Memoria RAM** *(opcional)*
6. **Periféricos** *(opcional)*
7. **Procesador (final)**

Cada paso:

* Puede **guardarse u omitirse**
* Muestra el **progreso visual**
* Mantiene consistencia de diseño con AdminLTE

---

## UX / UI destacadas

### Resaltado visual al crear / editar

Cuando se crea un nuevo equipo:

* Se redirige automáticamente a la **página correcta de la paginación**
* Con ayuda de un 'Badge' el activo recien editado **resalta visualmente**

---

## Estructura mental del proyecto

* **Controllers** → lógica de negocio
* **Views (Blade)** → presentación
* **Models** → relaciones y datos
* **Session flash** → UX (mensajes, highlights)
* **Wizard** → flujo controlado y claro

---

## Buenas prácticas aplicadas

* Separación de responsabilidades
* UX clara (feedback visual)
* Componentes opcionales (no forzados)

---



## Autor
Johan Jael Lòpez Reyes (Universidad Tecnologica de Morelia)
Proyecto desarrollado como sistema de gestión de activos TI con enfoque académico y profesional.

---

> "Primero que funcione, luego que se vea bien, y al final que se sienta
