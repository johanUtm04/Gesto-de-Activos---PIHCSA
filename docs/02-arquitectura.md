# 2. Arquitectura del Sistema

## 2.1 Visión general

El sistema de Gestión de Activos de **PIHCSA** es una **aplicación web empresarial** diseñada para el control, seguimiento y auditoría de activos de la empresa.  

El sistema reemplaza un modelo basado en hojas de cálculo por una solución centralizada, estructurada y segura, permitiendo un control más preciso de los activos a lo largo de su ciclo de vida.

---

## 2.2 Arquitectura MVC

El sistema está construido sobre el framework **Laravel**, siguiendo el patrón de arquitectura **Modelo–Vista–Controlador (MVC)**, lo que garantiza una separación clara de responsabilidades:

- **Modelos (Models)**  
  Representan la estructura de los datos y las relaciones entre entidades (activos, usuarios, componentes, ubicaciones, etc.).

- **Controladores (Controllers)**  
  Contienen la lógica de negocio del sistema.  
  Gestionan la interacción entre las solicitudes del usuario, los modelos y las vistas.

- **Vistas (Views)**  
  Implementadas con **Blade**, se encargan de la presentación visual de la información, apoyadas por **AdminLTE** para mantener una interfaz clara y consistente.

Este enfoque facilita la mantenibilidad, escalabilidad y legibilidad del código.

---

## 2.3 Flujo general de la aplicación

El flujo típico de uso del sistema es el siguiente:

1. El usuario se autentica en el sistema  
2. Accede al módulo de inventario de activos  
3. Consulta, registra o modifica un activo  
4. El sistema valida los datos ingresados  
5. La información se persiste en la base de datos  
6. Se registra el historial de cambios y acciones  
7. El usuario recibe retroalimentación visual (mensajes y resaltados)

Este flujo garantiza consistencia de datos y una experiencia de usuario clara.

---

## 2.4 Componentes principales del sistema

El sistema se compone de los siguientes módulos principales:

- **Gestión de Activos - wizard**  
  Registro y administración de activos de la empresa tomando un activo con datos base y a este sumandosele de manera opcional diferentes componentes (perifericos, rams, monitores, etc.)

- **Usuarios y roles**  
  Control de acceso basado en permisos.

- **Auditoría e historial**  
  Registro de cambios, asignaciones y mantenimientos.

- **Mantenimiento de activos**  
  Seguimiento de intervenciones técnicas realizadas a los equipos.

Cada módulo está desacoplado y cumple una función específica dentro del sistema.

---

## 2.5 Arquitectura de datos (alto nivel)

El sistema utiliza una **base de datos relacional MySQL**, diseñada para mantener la integridad y consistencia de la información.

Las principales características de la arquitectura de datos son:

- Relaciones normalizadas entre entidades  
- Integridad referencial mediante claves foráneas  
- Asociación de componentes a activos  
- Historial vinculado a cada activo  

El detalle de las tablas y relaciones se documenta en la sección de base de datos.

---

## 2.6 Seguridad

La seguridad del sistema se basa en los mecanismos proporcionados por Laravel:

- Autenticación de usuarios  
- Autorización mediante roles y permisos  
- Protección de rutas sensibles  
- Validación de datos de entrada  

Estos controles garantizan que cada usuario solo pueda acceder a las funcionalidades autorizadas.

---

## 2.7 Despliegue

El sistema está diseñado para ejecutarse en un entorno de servidor **Linux**, utilizando un stack web estándar.

Características del despliegue:

- Servidor web (Apache o Nginx)  
- PHP como lenguaje de ejecución  
- MySQL como base de datos  
- Acceso mediante navegador web  

Se contemplan entornos separados para **desarrollo** y **producción**.

---

## English

---

# 2. System Architecture

## 2.1 Overview

The **PIHCSA Asset Management System** is an **enterprise web application** designed for the control, tracking, and auditing of company assets.  


The system replaces a spreadsheet-based approach with a centralized, structured, and secure solution, enabling accurate asset tracking throughout its lifecycle.

---

## 2.2 MVC Architecture

The system is built on the **Laravel** framework, following the **Model–View–Controller (MVC)** architectural pattern, ensuring a clear separation of concerns:

- **Models**  
  Represent the data structure and relationships between entities (assets, users, components, locations, etc.).

- **Controllers**  
  Contain the business logic of the system.  
  They manage the interaction between user requests, models, and views.

- **Views**  
  Implemented using **Blade**, they handle the visual presentation of information, supported by **AdminLTE** to ensure a consistent and clear user interface.

This approach improves maintainability, scalability, and code readability.

---

## 2.3 General application flow

The typical usage flow of the system is as follows:

1. The user authenticates into the system  
2. Accesses the asset inventory module  
3. Views, creates, or updates an asset  
4. The system validates the submitted data  
5. Information is persisted in the database  
6. Change history and actions are recorded  
7. The user receives visual feedback (messages and highlights)

This flow ensures data consistency and a clear user experience.

---

## 2.4 Main system components

The system is composed of the following main modules:

- **Asset Management - Wizard**
Registration and administration of company assets by taking a base asset with data and optionally adding different components (peripherals, RAM, monitors, etc.)

- **Users and Roles**  
  Role-based access control.

- **Audit and History**  
  Tracking of changes, assignments, and maintenance actions.

- **Asset Maintenance**  
  Monitoring of technical interventions performed on assets.

Each module is decoupled and fulfills a specific responsibility within the system.

---

## 2.5 Data architecture (high level)

The system uses a **MySQL relational database**, designed to maintain data integrity and consistency.

Key characteristics of the data architecture include:

- Normalized relationships between entities  
- Referential integrity through foreign keys  
- Asset-to-component associations  
- Historical records linked to each asset  

Detailed table structures and relationships are documented in the database section.

---

## 2.6 Security

System security relies on Laravel’s built-in mechanisms:

- User authentication  
- Role and permission-based authorization  
- Protection of sensitive routes  
- Input data validation  

These controls ensure that users can only access authorized functionality.

---

## 2.7 Deployment

The system is designed to run on a **Linux server environment**, using a standard web stack.

Deployment characteristics:

- Web server (Apache or Nginx)  
- PHP runtime  
- MySQL database  
- Browser-based access  

Separate environments for **development** and **production** are considered.

---
