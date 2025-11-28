<script>
import { usePage } from '@inertiajs/vue3'
// import Layout from "@/Layouts/main.vue"
// import Layout from "@/Layouts/maindashboard.vue"
// import Layout from "@/Layouts/layout-sidebar.vue"
import PageHeader from "@/Components/header/header.vue"
import DataTable from '@/Components/DataTable.vue'
import { useFetchPetition } from '@/Composables/useFetchPetition.js';
import { useAlert } from '@/Composables/useSweetAlert.js';

const { showAlert, showConfirm } = useAlert();
const { fetchPetition } = useFetchPetition();

export default {
    name: 'productosIndex',
    components: {
        // Layout,
        PageHeader,
        DataTable,
    },
    data() {
        return {
            searchQuery: '',
            productos: [],
            mostrarModalProductos: false,
            form: {
                codigo: '',
                nombre: '',
                observaciones: '',
                estado: true,
            },
        }
    },
    // props: {
    //     productos: {
    //         type: Object,
    //         required: true,
    //         default: () => ({ data: [], meta: { total: 0 } })
    //     }
    // },
    computed: {
        tableHeaders() {
            return [
                { label: 'Código', key: 'codigo' },
                { label: 'Nombre', key: 'nombre' },
                { label: 'Estado', key: 'estado' },
                { label: 'Acciones', key: 'acciones' },
            ]
        },
    },
    mounted() {
        this.$nextTick(() => {
            this.ListarProductos();
        });
    },
    methods: {
        getStatusClass(status) {
            const classes = {
                1: 'badge bg-success-subtle text-success',
                0: 'badge bg-danger-subtle text-danger'
            };
            return classes[status] || 'bg-secondary-subtle';
        },

        getStatusText(status) {
            const texts = {
                1: 'Activo',
                0: 'Inactivo'
            };
            return texts[status] || 'Desconocido';
        },

        async ListarProductos() {
            const response = await fetchPetition(`/listarProductos`, {
                method: 'GET'
            });
            if (response.ok) {
                    console.log('Productos listados:', response.data);
                    this.productos = response.data?.data;
                } else {
                    showAlert('error', 'Error', 'No se pudieron listar los productos', 2000);
                }
        },

        async aliminarProducto(id) {
            try {
                const confirmed = await showConfirm(
                    'warning',
                    '¡Alerta!',
                    '¿Está seguro que desea eliminar el producto?',
                    'Sí, eliminar'
                );
                if (!confirmed) return;
                const response = await fetchPetition(`/productos/${id}`, {
                    method: 'DELETE'
                });
                if (response.ok) {
                    showAlert('success', '¡Éxito!', 'El producto ha sido eliminado correctamente', 1500);
                    this.ListarProductos();
                } else {
                    console.warn('Error al eliminar producto:', response.status, response.data);
                    showAlert('error', 'Error', 'Error al eliminar el producto', 2000);
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Error inesperado', 'Ocurrió un problema al eliminar el producto', 2000);
            }
        },

        async GuardarProducto() {
            const form = this.form;
            form.estado = this.form.estado ? 1 : 0;
            try {
                const response = await fetchPetition(`/productos`, {
                    method: 'POST',
                    body: form,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (response.ok) {
                    showAlert('success', '¡Éxito!', 'El producto ha sido guardado correctamente', 1500);
                    this.ListarProductos();
                    this.cerarModalProducto();
                } else {
                    console.warn('Error al guardar producto:', response.status, response.data);
                    showAlert('error', 'Error', 'Error al guardar el producto', 2000);
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Error inesperado', 'Ocurrió un problema al guardar el producto', 2000);
            }
        },

        mostrarModalProducto() {
            this.mostrarModalProductos = true;
        },

        cerarModalProducto(){
            this.mostrarModalProductos = false;
            this.form = {
                codigo: '',
                nombre: '',
                observaciones: '',
                estado: true,
            };
        }
    }
}
</script>

<template>
    <Layout>
        <PageHeader title="Gestión de Productos" pageTitle="Maestras" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Productos</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <!-- <a :href="route('productos.create')" class="btn btn-success add-btn"> -->
                                    <a class="btn btn-success add-btn" @click="mostrarModalProducto()">
                                        <i class="ri-add-line align-bottom me-1"></i> Nuevo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom-dashed border-bottom">
                        <div class="row g-3">
                            <div class="col-xl-12">
                                <div class="">
                                    <input type="text" class="form-control" placeholder="Buscar..." v-model="searchQuery">
                                    <!-- <i class="ri-search-line search-icon"></i> -->
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <div class="card-body">
                        <div>
                            <!-- Tabla reutilizable -->
                            <DataTable
                                id="tabla-productos"
                                :headers="tableHeaders"
                                :items="productos"
                                :page-length="20"
                                order-by="code"
                            >
                                <!-- Custom cell: status -->
                                <!-- <template #cell-status="{ item }">
                                    <span class="badge" :class="getStatusClass(item.status)">
                                        {{ getStatusText(item.status) }}
                                    </span>
                                </template> -->

                                <!-- Custom cell: acciones -->
                                <!-- <template #cell-acciones="{ item }">
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item">
                                            <a :href="`/productos/${item.id}/show`" class="text-primary" title="Ver" @click="showYard(item.id)">
                                                <i class="ri-eye-fill fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item edit">
                                            <a :href="`/productos/${item.id}/edit`" class="text-primary" title="Editar">
                                                <i class="ri-pencil-fill fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" class="text-danger" title="Eliminar" @click="deleteYard(item.id)">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </template> -->
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="mostrarModalProductos" id="modalProductos" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header p-3 bg-light">
                        <h5 class="modal-title">Producto</h5>
                        <button type="button" class="btn-close" @click="cerarModalProducto()"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Código</label>
                                    <input type="text" v-model="form.codigo" class="form-control" placeholder="Ingrese Código">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" v-model="form.nombre" class="form-control" placeholder="Ingrese Nombre">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <textarea class="form-control" v-model="form.observaciones" rows="3" placeholder="Ingrese Observaciones"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Estado</label>
                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                        <input
                                            v-model="form.estado"
                                            type="checkbox"
                                            class="form-check-input"
                                            id="customSwitchsizesm"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" @click="cerarModalProducto()">Cancelar</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="GuardarProducto()"
                        >Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
    .search-box {
        position: relative;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        color: #74788d;
    }

    .fs-15 {
        font-size: 0.9375rem;
    }
</style>

