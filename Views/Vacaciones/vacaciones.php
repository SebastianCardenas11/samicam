<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-calendar-week"></i> <?=$data['page_title']?></h1>
        </div>
    </div>
    
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
        <li class="breadcrumb-item"><a href="<?=base_url();?>/vacaciones"><?=$data['page_title']?></a></li>
    </ul>


    

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-estilo" id="tableFuncionarios">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center">Nombre completo</th>
                                    <th class="text-center">Identificación</th> 
                                    <th class="text-center">Cargo</th> 
                                    <th class="text-center">Fecha Ingreso</th>
                                    <th class="text-center">Años Servicio</th>
                                    <th class="text-center">Períodos Disponibles</th>
                                    <th class="text-center">Acciones</th>
                             </tr>
                            </thead>
                            <tbody class="table-group-divider text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
getModal('modalVacaciones', $data);
footerAdmin($data);
?>