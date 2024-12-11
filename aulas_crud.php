<?php


    class AulasCRUD extends ProgramaBase
    {
        const LIMITE_SCROLL = 5;

        function __construct()
        {

            $this->aula = new Aulas();


            parent::__construct($this->aula);

        }

        function inicializar()
        {
            $this->form->accion('/'. $this->seccion .'/');

            $paso        = new Hidden('paso'); 
            $paso->value = 1;

            $oper        = new Hidden('oper'); 
            $id          = new Hidden('id');        

            $nombre      = new Input   ('nombre'          ,['placeholder' => 'Nombre...'      , 'validar' => True, 'ereg' => EREG_TEXTO_100_OBLIGATORIO  ]);
            $letra       = new Textarea('letra'           ,['placeholder' => 'Letra...'       , 'validar' => True, 'ereg' => EREG_TEXTO_100_OBLIGATORIO ]);
            $numero        = new Input   ('numero'        ,['placeholder' => 'Numero...'      , 'validar' => True , 'ereg' => EREG_TEXTO_100_OBLIGATORIO  ]);
            $planta        = new Input   ('planta'        ,['placeholder' => 'Planta...'      , 'validar' => True , 'ereg' => EREG_TEXTO_100_OBLIGATORIO  ]);


            $this->form->cargar($paso);
            $this->form->cargar($oper);
            $this->form->cargar($id);
            $this->form->cargar($nombre);
            $this->form->cargar($letra);
            $this->form->cargar($numero);
            $this->form->cargar($planta);
        }


        function existe($id='')
        {

            $cantidad = 0;
            if (   !empty($this->form->val['nombre']) 
                && !empty($this->form->val['letra'])
                && !empty($this->form->val['numero'])
                && !empty($this->form->val['planta'])
                )
            {   

                $cantidad = $this->aula->existeAula(
                 $this->form->val['nombre']
                ,$this->form->val['letra']
                ,$this->form->val['numero']
                ,$this->form->val['planta']
                ,$this->form->val['id']
                );
            }

            return $cantidad;
        }


        function recuperar()
        {

            $this->aula->recuperar($this->form->val['id']);



            $this->form->elementos['nombre']->value     = $this->aula->nombre;
            $this->form->elementos['letra']->value      = $this->aula->letra;
            $this->form->elementos['numero']->value       = $this->aula->numero;
            $this->form->elementos['planta']->value       = $this->aula->planta;

        }


        function resultados_busqueda()
        {
            $listado_aulas = '
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Letra</th>
                        <th scope="col">Numero</th>
                        <th scope="col">Planta</th>
                    </tr>
                </thead>
                <tbody>
            
            ';

            

            $limite = AulasCrud::LIMITE_SCROLL;

            $pagina = $this->form->val['pagina'];

            $offset = $pagina * $limite;



            $opt = [];
    
            $opt['orderby']['fecha_ult_mod'] = 'DESC';   
            $opt['offset'] = $offset;
            $opt['limit']  = $limite;
        
        
            $resultado = $this->aula->seleccionar($opt);

            if ($resultado->num_rows > 0) 
            {
                while ($fila = $resultado->fetch_assoc()) 
                {
                    $listado_aulas .= "
                        <tr>
                            <th scope=\"row\">
                                ". enlace("/{$this->seccion}/actualizar/{$fila['id']}",'Actualizar',['class' => 'btn btn-primary']) ."
                                ". enlace("/{$this->seccion}/leer/{$fila['id']}",'Leer',['class' => 'btn btn-primary']) ."
                                ". enlace("#",'Eliminar',['class' => 'btn btn-danger','onclick' => "if(confirm('Cuidado, estás tratando de eliminar el aula: {$fila['nombre']}')) location.href = '/aulas/eliminar/{$fila['id']}';"]) ."
                            </th>
                            <td>{$fila['nombre']}</td>
                            <td>{$fila['letra']}</td>
                            <td>{$fila['numero']}</td>
                            <td>". Aulas::PLANTA[$fila['plantas']]."</td>
                        </tr>
                    ";
                }

                if ($resultado->num_rows == AulasCrud::LIMITE_SCROLL)
                    $siguiente = '<li class="page-item">'. enlace("/{$this->seccion}/pag/". ($pagina + 1), 'Siguiente',['class' => 'page-link']) .'</li>';
            } 
            else 
            {
                $listado_aulas = '<tr><td colspan="5">No hay resultados</td></tr>';
            }
            

            if($pagina)
                $pagina_anterior = '<li class="page-item">'. enlace("/{$this->seccion}/pag/". ($pagina - 1), 'Anterior',['class' => 'page-link']) .'</li>';
            

            $listado_aulas .= '
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        '. $pagina_anterior .'
                        '. $siguiente .'
                    </ul>
                </nav>


                <div class="alta">'. enlace("/{$this->seccion}/alta/", 'Alta de aula',['class' => 'btn btn-success']) .'</div>
            ';
            

            return $listado_aulas;


        }
    }





