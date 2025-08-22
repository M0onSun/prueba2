<?php require_once APP_DIR . '/views/layouts/header.php'; ?>
<!-- CSS -->
<link rel="stylesheet" href="/proyecto64/public/assets/dataTable/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="/proyecto64/public/assets/bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="/proyecto64/public/assets/css/custom-datatables.css">

<div class="container-fluid px-4 mt-4">
    <!-- Encabezado mejorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-primary"><i class="bi bi-people-fill me-2"></i>Gestion de Usuarios</h1>
        </div>

        <?php if ($_SESSION['user']['id_rol'] == 1): ?>
            <a href="<?= BASE_URL ?>users/create" class="btn btn-outline-success shadow-sm">
                <i class="bi bi-person-plus me-2"></i>Nuevo Usuario
            </a>
        <?php endif; ?>
    </div>

    <!-- Alertas mejoradas -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Tarjeta principal con sombra y bordes redondeados -->
    <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Listado de Usuarios
                </h5>
                <div class="d-flex">
                    <button id="btnExportExcel" class="btn btn-sm btn-success me-2">
                        <i class="bi bi-file-earmark-excel me-1"></i> Excel
                    </button>
                    <button id="btnExportPDF" class="btn btn-sm btn-danger">
                        <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- filtros avanzados -->
            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" id="filtroGeneral" class="form-control border" placeholder="Buscar en todos los campos...">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" id="filtroFecha" class="form-control border">
                </div>
                <div class="col-md-2">
                    <button id="btnResetFiltros" class="btn btn-outline-info btn-lg w-100">
                        <i class="bi bi-arrow-repeat me-1"></i> Limpiar
                    </button>
                </div>
            </div>

            <!-- Tabla mejorada -->
            <div class="table-responsive">
                <table id="tablaUsuarios" class="table table-hover table-striped table-bordered nonrep" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Nombre Completo</th>
                            <th width="25%">Correo</th>
                            <th width="15%">Rol</th>
                            <th width="20%">Fecha Registro</th>
                            <th width="10%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id_usuario']) ?></td>
                            <td class="text-uppercase"><?= htmlspecialchars($user['nombre'] . ' '. $user['apaterno'] . ' '. $user['amaterno']) ?></td>
                            <td class="correo">
                                <a href="mailto:<?= htmlspecialchars($user['correo']) ?>" class="text-decoration-none">
                                    <i class="bi bi-envelope me-2 text-muted"></i>
                                    <?= htmlspecialchars($user['correo']) ?>
                                </a>
                            </td>
                            <td class="rol">
                                <span class="badge <?= $user['rol'] == 'Admin' ? 'bg-danger' : ($user['rol'] == 'Usuario' ? 'bg-primary' : 'bg-success') ?>">
                                    <?= htmlspecialchars($user['rol']) ?>
                                </span>
                            </td>
                        <!--EN ESTA PARTE SE COLOCO PARA QUE MUESTRE LA FECHA DEL SISTEMA-->
                            <td>
                                <?= date('d/m/Y') ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="<?= BASE_URL ?>users/edit/<?= $user['id_usuario'] ?>" 
                                       class="btn btn-sm btn-outline-warning rounded-circle me-2 action-btn"
                                       data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <?php if ($_SESSION['user']['id_rol'] == 1): ?>
                                        <a href="<?= BASE_URL ?>users/delete/<?= $user['id_usuario'] ?>" 
                                           class="btn btn-sm btn-outline-danger rounded-circle action-btn"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"
                                           onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
<!-- Scripts mejorados con rutas corregidas -->
<script src="/proyecto64/public/assets/dataTable/js/jquery/jquery-3.6.0.min.js"></script>
<script src="/proyecto64/public/assets/dataTable/js/datatables/jquery.dataTables.min.js"></script>
<script src="/proyecto64/public/assets/dataTable/js/datatables/dataTables.bootstrap5.min.js"></script>
<script src="/proyecto64/public/assets/dataTable/js/datatables/accent-neutralise.js"></script>
<script src="/proyecto64/public/assets/dataTable/js/jsPDF/jspdf.umd.min.js"></script>
<script src="/proyecto64/public/assets/dataTable/js/jsPDF/jspdf.plugin.autotable.min.js"></script>
<script>const { jsPDF } = window.jspdf;</script>
<script>
    $(document).ready(function () {
        // Función auxiliar MUCHO MÁS ROBUSTA para obtener el texto plano de la celda
        function getCellText(cellData) {
            let tempDiv = $('<div>'); // Creamos un div temporal para manipular el contenido

            if (typeof cellData === 'string') {
                // Si cellData ya es un string, lo cargamos en el div
                tempDiv.html(cellData);
            } else if (cellData instanceof jQuery) {
                // Si es un objeto jQuery, lo clonamos para no alterar el original
                tempDiv.append(cellData.clone());
            } else if (cellData && typeof cellData === 'object' && cellData.nodeType === 1) {
                // Si es un nodo DOM nativo, lo clonamos
                tempDiv.append($(cellData).clone());
            } else {
                // Para cualquier otro tipo de dato, lo convertimos a string
                tempDiv.text(String(cellData));
            }

            // Extraer el texto, reemplazar múltiples espacios/saltos de línea por un solo espacio, y trim
            return tempDiv.text().replace(/\s+/g, ' ').trim();
        }

        // Inicialización de DataTable con botones ocultos
        let table = $('#tablaUsuarios').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "decimal": ",",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "emptyTable": "No hay datos disponibles en la tabla",
                "aria": {
                    "sortAscending": ": activar para ordenar columna ascendente",
                    "sortDescending": ": activar para ordenar columna descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad columnas",
                    "collection": "Colección",
                    "colvisRestore": "Restaurar visibilidad",
                    "copyKeys": "Presione Ctrl o u2318 + C para copiar los datos de la tabla al portapapeles.<br><br>Para cancelar, haga clic en este mensaje o presione escape.",
                    "copySuccess": {
                        "1": "Copiada 1 fila al portapapeles",
                        "_": "Copiadas %d filas al portapapeles"
                    },
                    "copyTitle": "Copiar al portapapeles",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "_": "Mostrar %d filas"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir"
                },
                "select": {
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "%d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    },
                    "rows": {
                        "1": "1 fila seleccionada",
                        "_": "%d filas seleccionadas"
                    }
                }
            },
            responsive: true,
            stateSave: true,
            buttons: []
        });
        // Configurar el buscador personalizado
        $('#filtroGeneral').on('keyup', function() {
            table.search(this.value).draw();
        });
        // Filtro por fecha
        $('#filtroFecha').on('change', function() {
            try {
                if(this.value) {
                    // Validar formato de fecha
                    if(!/^\d{4}-\d{2}-\d{2}$/.test(this.value)) {
                        console.error('Formato de fecha inválido');
                        return;
                    }
                    
                    const parts = this.value.split('-');
                    if(parts.length !== 3) {
                        console.error('Fecha mal formada');
                        return;
                    }
                    
                    const searchDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
                    table.column(4).search(searchDate).draw();
                } else {
                    table.column(4).search('').draw();
                }
            } catch(error) {
                console.error('Error en filtro de fecha:', error);
            }
        });
        // Botón para resetear filtros
        $('#btnResetFiltros').on('click', function() {
            $('#filtroGeneral').val('');
            $('#filtroFecha').val('');
            table.search('').columns().search('').draw();
        });
        // Inicializar tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Exportar a Excel
        $('#btnExportExcel').on('click', function() {
            let csvContent = "data:text/csv;charset=utf-8,";
            
            let headers = ["ID", "Nombre Completo", "Correo", "Rol", "Fecha Registro"];
            csvContent += headers.join(",") + "\r\n";
            
            table.rows({ search: 'applied' }).data().each(function(row) {
                let rowData = [
                    getCellText(row[0]),
                    '"' + getCellText(row[1]) + '"',
                    '"' + getCellText(row[2]) + '"', // Columna Correo
                    '"' + getCellText(row[3]) + '"', // Columna Rol
                    '"' + getCellText(row[4]) + '"'  // Columna Fecha
                ];
                csvContent += rowData.join(",") + "\r\n";
            });
            
            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "usuarios_" + new Date().toISOString().slice(0,10) + ".csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Exportar a PDF (Versión mejorada para tamaño Carta, Horizontal y Numeración)
        $('#btnExportPDF').on('click', function() {
            // Crear un nuevo PDF en formato horizontal y tamaño carta
            // 'l' para landscape (horizontal), 'pt' para unidades de medida en puntos, 'letter' para tamaño Carta
            let doc = new jsPDF('l', 'pt', 'letter'); 
            
            let fechaDescarga = new Date().toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            doc.setFontSize(16);
            doc.text('Listado de Usuarios', 40, 40); // Ajustado a un margen más genérico para el título
            doc.setFontSize(10);
            doc.text('Generado el: ' + fechaDescarga, 40, 55); // Ajustado

            // Definir encabezados de tabla
            let headers = [
                {title: "ID", dataKey: "id"},
                {title: "Nombre Completo", dataKey: "nombreCompleto"},
                {title: "Correo", dataKey: "correo"},
                {title: "Rol", dataKey: "rol"},
                {title: "Fecha Registro", dataKey: "fecha"}
            ];
            
            // Preparar los datos de la tabla
            let data = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                data.push({
                    id: getCellText(row[0]),
                    nombreCompleto: getCellText(row[1]),
                    correo: getCellText(row[2]),
                    rol: getCellText(row[3]),
                    fecha: getCellText(row[4])
                });
            });
            
            doc.autoTable({
                columns: headers,
                body: data,
                startY: 80, // Iniciamos la tabla más abajo para dejar espacio al título/fecha y márgenes superiores
                margin: { top: 70, right: 40, bottom: 40, left: 40 }, // Márgenes de la tabla (más espacio superior, derecha e izquierda)
                styles: {
                    fontSize: 10, // Aumentamos un poco el tamaño de fuente para mejor lectura
                    cellPadding: 4, // Aumentamos el padding de celda
                    overflow: 'linebreak'
                },
                columnStyles: {
                    // Ajustamos significativamente los anchos de columna para una hoja Carta horizontal
                    // (Ancho total de una hoja carta horizontal es 792 pt, con márgenes de 40pt a cada lado quedan 712pt disponibles)
                    id: { cellWidth: 50 }, 
                    nombreCompleto: { cellWidth: 160 }, 
                    correo: { cellWidth: 180 }, 
                    rol: { cellWidth: 100 }, 
                    fecha: { cellWidth: 120 } 
                    // Suma de cellWidth: 50 + 160 + 180 + 100 + 120 = 610pt. 
                    // Esto deja espacio para el padding y se ajusta mejor.
                },
                didDrawPage: function(data) {
                    doc.setFontSize(9); // Tamaño de fuente para la numeración
                    doc.setTextColor(150); // Color gris para la numeración
                    
                    let pageSize = doc.internal.pageSize;
                    let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                    let pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();
                    
                    let text = 'Página ' + data.pageNumber;
                    // Posición para la numeración (parte inferior centrada o ligeramente a la derecha)
                    // Centrado: pageWidth / 2
                    // Ligeramente a la derecha: pageWidth - data.settings.margin.right
                    doc.text(text, pageWidth - data.settings.margin.right, pageHeight - 20, {align: 'right'}); 
                    // Alineamos a la derecha para que el texto 'Página X' empiece más a la izquierda y no se corte
                }
            });
            
            doc.save('usuarios_' + new Date().toISOString().slice(0,10) + '.pdf');
        });
    });
</script>