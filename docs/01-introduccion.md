# 📑 1. Introducción al Proyecto

> **Nota para el futuro Ingeniero:**
> Este documento marca la pauta de *por qué* existe este sistema. Cuando el código se vuelva complejo, vuelve aquí para recordar que el valor real de PIHCSA Activos no es solo guardar datos, sino eliminar el caos de los archivos Excel y convertirlos en **integridad operativa**.

---

## 🎯 1.1 Objetivos y Métricas de Éxito

Esta sección define el marco de referencia estratégico. Todo componente desarrollado en Laravel (Modelos, Vistas o Controladores) debe alinearse con estos pilares.



### 🚀 Visión General
El objetivo primordial es **modernizar y profesionalizar la gestión de activos de TI** en **PIHCSA (Sede Morelia)**. El sistema reemplaza el flujo arcaico de hojas de cálculo por una infraestructura web centralizada.

#### 🛡️ Problemática Actual (El "Por qué")
* **Volatilidad de Datos:** Errores manuales frecuentes en Excel.
* **Puntos Ciegos:** Falta de trazabilidad histórica de quién tuvo qué equipo.
* **Silencios Técnicos:** Ausencia de registros de mantenimiento y auditoría.

#### 💎 Propuesta de Valor (El "Cómo")
* **Estructura:** Registro de activos mediante formularios validados (Wizard).
* **Trazabilidad:** Historial completo (`historiales_log`) de cada movimiento.
* **Accesibilidad:** Aplicación web centralizada en **Laravel + MySQL** sobre servidores **Linux**.

---

## 📈 1.2 Métricas de Éxito (KPIs)

El éxito de este desarrollo se evalúa bajo los siguientes indicadores técnicos y operativos:

| Indicador | Meta / Objetivo | Impacto esperado |
| :--- | :--- | :--- |
| **Integridad de Datos** | 0% Registros huérfanos | Uso estricto de llaves foráneas y validaciones. |
| **Rendimiento** | < 5s por consulta | Optimización mediante *Eager Loading* en controladores. |
| **Centralización** | 100% de activos en DB | Eliminación total de archivos Excel externos. |
| **Auditoría** | Log completo por activo | Capacidad de reconstruir la historia de cualquier ID. |

---

## 🛠️ 1.3 Stack Tecnológico

Para asegurar la **integridad y consistencia a largo plazo**, se seleccionaron las siguientes herramientas:

* **Backend:** PHP 8.x + Laravel Framework (Robustez y seguridad).
* **Base de Datos:** MySQL (Relacionamiento estricto de hardware).
* **Servidor:** Linux (Estabilidad para entornos productivos).
* **Clientes:** Compatible con estaciones de trabajo Windows y Linux.

---

### 💡 Impacto esperado
La implementación de este sistema transformará la gestión de TI en una ventaja competitiva, garantizando que la información financiera (Depreciación) y técnica (Hardware) sea **verificable, auditable y escalable**.

---
**Última revisión de objetivos:** Enero, 2026.