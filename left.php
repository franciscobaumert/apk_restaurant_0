<!-- Main Sidebar Start -->
<aside class="main-sidebar">
  <section class="sidebar">

    <!--  Sidebar User Panel Start-->
    <div class="user-panel">
      <div class="pull-left image">
        <svg class="svg-icon"><use href="#icon-avatar"></svg>
      </div>
      <div class="pull-left info">
        <p class="username" title="">
          YOUR NAME
        </p>
        <a href="" onClick="return false;">
          <i class="fa fa-circle user-status-dot"></i> 
          ADMIN 
        </a>
      </div>
    </div>  
    <!-- Sidebar User Panel End -->

    <!-- Sidebar Menu Start -->
    <ul class="sidebar-menu">
      <li class="">
        <a href="resumen.php">
          <svg class="svg-icon"><use href="#icon-dashboard"></svg>
          <span>
            TABLERO
          </span>
        </a>
      </li>

      
        <li class="">
          <a href="nueva_factura.php">
            <svg class="svg-icon"><use href="#icon-create-invoice"></svg>
            <span>
              PUNTO DE VENTA
            </span>
          </a>
        </li>     

      
        <li class="treeview">
          <a href="clientes.php">
            <svg class="svg-icon"><use href="#icon-group"></svg>
            <span>
              CLIENTES
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
              <li class="">
                <a href="clientes.php">
                  <svg class="svg-icon"><use href="#icon-group"></svg>
                  <span>
                    CLIENTES
                  </span>
                </a>
              </li>
            
              <li class="">
                <a href="ingresocliente.php">
                  <svg class="svg-icon"><use href="#icon-list"></svg>
                   CONSULTA SUNAT
                </a>
              </li>
              <li class="">
                <a href="ingresocliente_dni.php">
                  <svg class="svg-icon"><use href="#icon-list"></svg>
                   CONSULTA RENIEC
                </a>
              </li>
          </ul>
        </li>

      
        <li class="">
          <a href="proveedores.php">
            <svg class="svg-icon"><use href="#icon-supplier"></svg>
            <span>
              PROVEEDORES
            </span>
          </a>
        </li>

      
        <li class="treeview">
          <a href="productos.php">
            <svg class="svg-icon"><use href="#icon-star"></svg>
            <span>
              PRODUCTOS
            </span> 
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
              <li class="">
                <a href="productos.php">
                  <svg class="svg-icon"><use href="#icon-star"></svg>
                  PRODUCTOS
                </a>
              </li>
            
              <li class="">
                <a href="categorias.php">
                  <svg class="svg-icon"><use href="#icon-category"></svg>
                   CATEGORIAS
                </a>
              </li>
            
              <li class="">
                <a href="ingresoproductos.php">
                  <svg class="svg-icon"><use href="#icon-import"></svg>
                  INGRESAR PRODUCTOS
                </a>
              </li>
            
              <li class="">
                <a href="kardex.php">
                  <svg class="svg-icon"><use href="#icon-alert"></svg>
                  KARDEX
                </a>
              </li>
            
              <li class="">
                <a href="consultaproductos.php">
                  <svg class="svg-icon"><use href="#icon-expired"></svg>
                  CONSULTAS
                </a>
              </li>
              <li class="">
                <a href="consultaprecios.php">
                  <svg class="svg-icon"><use href="#icon-expired"></svg>
                  PRECIOS
                </a>
              </li>
          </ul>
        </li>

  
        <li class="treeview">
          <a href="transfer.php">
            <svg class="svg-icon"><use href="#icon-transfer"></svg>
            <span>
              TRANSFERENCIAS
            </span> 
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
              <li class="">
                <a href="transfer.php">
                  <svg class="svg-icon"><use href="#icon-transfer"></svg>
                  TRANFERENCIAS
                </a>
              </li>
            
              <li class="">
                <a href="transfer.php?box_state=open">
                  <svg class="svg-icon"><use href="#icon-plus"></svg>
                   TRANSFERIR
                </a>
              </li>
          </ul>
        </li>

      
        <li class="treeview">
          
          <a href="purchage.php">
            <svg class="svg-icon"><use href="#icon-money"></svg>
            <span>COMPRAS</span>
             <i class="fa fa-angle-left pull-right"></i>
           </a>
         
          <ul class="treeview-menu">
            
              <li class="">
                <a ng-click="BuyingProductModal({sup_id:'',invoice_id:''});" onClick="return false;" href="purchase.php">
                  <svg class="svg-icon"><use href="#icon-plus"></svg>
                  <span>
                    AÑADIR COMPRA
                  </span>
                </a>
              </li>
            
            
              <li class="">
                <a href="purchase.php">
                  <svg class="svg-icon"><use href="#icon-list"></svg>
                  <span>
                    LISTA DE COMPRAS
                  </span>
                </a>
              </li>

          </ul>
        </li>

      

      <li class="">
      
        <a href="report_overview.php">
          <svg class="svg-icon"><use href="#icon-report"></svg>
          <span>INFORMES</span>
           <i class="fa fa-angle-left pull-right"></i>
         </a>
        

        <ul class="treeview-menu">
          
          
            <li class="">
              <a href="report_overview.php">
                <svg class="svg-icon"><use href="#icon-eye"></svg>
                MAS VENDIDOS
              </a>
            </li>
          

          
            <li class="">
              <a href="report_collection.php">
                <svg class="svg-icon"><use href="#icon-report"></svg>
                COMPRAS POR USUARIO
              </a>
            </li>
          

          
            <li class="">
              <a href="report_customer_due_collection.php">
                <svg class="svg-icon"><use href="#icon-report"></svg>
                COMPRAS POR PROVEEDOR
              </a>
            </li>
          

          
            <li class="">
              <a href="report_supplier_due_paid.php">
                <svg class="svg-icon"><use href="#icon-report"></svg>
                RESUMEN DE COMPRAS
              </a>
            </li>
          

          
            <li class="">
              <a href="report_sell_itemwise.php"> 
                <svg class="svg-icon"><use href="#icon-report"></svg>
                VENTAS POR USUARIO
              </a>
            </li>
          

          
            <li class="">
              <a href="report_buy_supplierwise.php">
                <svg class="svg-icon"><use href="#icon-report"></svg>
                <span>
                  VENTAS POR CLIENTE
                </span>
              </a>
            </li>
          

          
            <li class="">
              <a href="report_sell_payment.php">
                <svg class="svg-icon"><use href="#icon-report"></svg>
                <span>
                  RESUMEN DE VENTAS
                </span>
              </a>
            </li>
          
        </ul>
      </li>


      
        <li class="treeview">
          <a href="bank_transactions.php?type=report">
            <svg class="svg-icon"><use href="#icon-bank"></svg>
            <span>
              FACT. ELECTRONICA
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
              <li class="">
                <a href="bank_transfer.php">
                  <svg class="svg-icon"><use href="#icon-plus"></svg>
                  CONFIGURACION
                </a>
              </li>
            
              <li class="">
                <a href="bank_transfer.php">
                  <svg class="svg-icon"><use href="#icon-expense"></svg>
                  DOC. ELECTRONICOS
                </a>
              </li>
            
              <li>
                <a href="bank_transfer.php">
                  <svg class="svg-icon"><use href="#icon-plus"></svg>
                  RESUMEN DE BOLETAS
                </a>
              </li>
            
              <li class="">
                <a href="bank_transfer.php">
                  <svg class="svg-icon"><use href="#icon-import"></svg>
                  COMUNICACION DE BAJA
                </a>
              </li>
            
              <li class="">
                <a href="bank_transactions.php">
                  <svg class="svg-icon"><use href="#icon-list"></svg>
                  GUIA DE REMISION
                </a>
              </li>
            
          </ul>
        </li>

      
        <li class="treeview">
          <a href="expense.php">
            <svg class="svg-icon"><use href="#icon-expense"></svg>
            <span>
              VENTAS
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
              <li class="">
                <a href="expense.php?box_state=open">
                  <svg class="svg-icon"><use href="#icon-plus"></svg>
                  PUNTO DE VENTA
                </a>
              </li>
            
              <li class="">
                <a href="expense.php">
                  <svg class="svg-icon"><use href="#icon-list"></svg>
                  REALIZAR NOTA
                </a>
              </li>
            
              <li class="">
                <a href="expense_category.php">
                  <svg class="svg-icon"><use href="#icon-list"></svg>
                  VENTAS
                </a>
              </li>
            
              <li class="">
                <a href="expense_category.php">
                  <svg class="svg-icon"><use href="#icon-report"></svg>
                  COTIZACIONES
                </a>
              </li>

              <li class="">
                <a ng-click="ExpenseSummaryModal();" onClick="return false;" href="expense.php">
                  <svg class="svg-icon"><use href="#icon-report"></svg>
                  NOTAS
                </a>
              </li>
          </ul>
        </li>


      
        <li class="treeview">
          <a href="user.php">
            <svg class="svg-icon"><use href="#icon-user"></svg>
            <span>
              USUARIOS
            </span> 
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
              <li class="">
                <a href="user.php">
                  <svg class="svg-icon"><use href="#icon-user"></svg>
                  <span>
                    USUARIOS
                  </span>
                </a>
              </li>
            
              <li class="">
                <a href="user_group.php">
                  <svg class="svg-icon"><use href="#icon-group"></svg>
                  <span>
                    ACCESOS
                  </span>
                </a>
              </li>
            
              <li class="">
                <a href="password.php">
                  <svg class="svg-icon"><use href="#icon-password"></svg>
                  <span>
                    VARIABLES DE DESCANSO
                  </span>
                </a>
              </li>

              <li class="">
                <a href="password.php">
                  <svg class="svg-icon"><use href="#icon-password"></svg>
                  <span>
                    LISTA DE ASISTENCIA
                  </span>
                </a>
              </li>

              <li class="">
                <a href="password.php">
                  <svg class="svg-icon"><use href="#icon-password"></svg>
                  <span>
                    CONSULTAR ASISITENCIA
                  </span>
                </a>
              </li>

              <li class="">
                <a href="password.php">
                  <svg class="svg-icon"><use href="#icon-password"></svg>
                  <span>
                    LISTA DE DESCANSO
                  </span>
                </a>
              </li>
          </ul>
        </li>
      

        <li class="treeview">
          
          <a href="store_single.php">
            <svg class="svg-icon"><use href="#icon-settings"></svg>
            <span>
              AJUSTE
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          
          <ul class="treeview-menu">

            
              <li class="">
                <a href="user_preference.php">
                  <svg class="svg-icon"><use href="#icon-heart"></svg>
                  <span>
                    EMPRESA
                  </span>
                </a>
              </li>
            
              <li class="">
                <a href="currency.php">
                  <svg class="svg-icon"><use href="#icon-money"></svg>
                  <span>
                    DOCUMENTOS
                  </span>
                </a>
              </li>
            
              <li class="">
                <a href="box.php">
                  <svg class="svg-icon"><use href="#icon-box"></svg>
                  <span>
                    CAJA
                  </span>
                </a>
              </li>
          </ul>
        </li>

      
        <li class="">
          <a href="../store_select.php">
            <svg class="svg-icon"><use href="#icon-list"></svg>
            <span>
              TIENDAS
            </span>
          </a>
        </li>
      
      <li id="sidebar-bottom"></li>
    </ul>
    
  </section>
</aside>
<!-- Main Sidebar End -->