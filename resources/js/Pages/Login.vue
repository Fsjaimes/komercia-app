<script setup>
import {
    getCurrentInstance,
    onMounted,
    onUnmounted,
    ref
} from 'vue';
import PasswordInput from '../../UI/passwordInput.vue';
import ParticlesJs from '../shared/@spk/reuseble-plugin/particles-js.vue';
import BaseImg from '../components/Baseimage/BaseImg.vue';
import authlayout from "../layouts/authlayout.vue";
import { Link, router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const baseUrl = __BASE_PATH__;

// Estado del formulario
const user = ref({
    email: 'admin@komercia.com',
    password: 'password123',
    remember: true
});

const processing = ref(false);
const errors = ref({});

const { proxy } = getCurrentInstance();
const theme = localStorage.getItem('vyzorcolortheme') || 'light';

// Función de login real con Sanctum
const login = async () => {
    processing.value = true;
    errors.value = {};

    try {

        const response = await axios.post('/login', {
            email: user.value.email,
            password: user.value.password,
            remember: user.value.remember
        });

        // Si llegamos aquí, el login fue exitoso
        // Recargamos la página para que Inertia reconozca la sesión
        window.location.href = `${baseUrl}/beauty`;

        // Opcional: mostrar toast
        if (proxy?.$toast) {
            proxy.$toast.success("¡Inicio de sesión exitoso!", {
                theme: theme,
                icon: true,
                hideProgressBar: false,
                autoClose: 3000,
                position: 'top-right',
            });
        }
    } catch (error) {
        processing.value = false;
        if (proxy?.$toast) {
            proxy.$toast.error("Credenciales inválidas", {
                theme: theme,
                icon: true,
                hideProgressBar: false,
                autoClose: 3000,
                position: 'top-right',
            });
        }
        console.error('Login error:', error);
    }
};

// Efectos de montaje (sin cambios)
onMounted(() => {
    const setBodyClass = (action) => {
        if (action === "add") {
            document.body.classList.add("authentication-background");
            document.body.style.display = 'block';
        } else {
            document.body.classList.remove("authentication-background");
            document.body.style.display = 'none';
        }
    };

    setBodyClass("add");

    const handleBeforeUnload = () => {
        setBodyClass("remove");
    };
    window.addEventListener("beforeunload", handleBeforeUnload);

    onUnmounted(() => {
        setBodyClass("remove");
        document.body.removeAttribute('style');
        window.removeEventListener("beforeunload", handleBeforeUnload);
    });
});
</script>

<template>
    <Head title="Login | Komercia - Belleza & POS" />
    <div class="authentication-basic-background">
        <BaseImg src="/images/brand-logos/komercia-login.png" alt="" />
    </div>
    <ParticlesJs />
    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                <div class="card custom-card border-0 my-4">
                    <div class="card-body p-sm-5">
                        <div class="mb-4 text-center">
                            <Link :href="`${baseUrl}/`">
                                <BaseImg
                                    src="/images/brand-logos/komercia-sidebar.png"
                                    alt="Komercia"
                                    class="desktop-dark"
                                    style="width: 150px; height: 70px;"
                                />
                            </Link>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-semibold">Hola, Bienvenido</h4>
                            <p class="mb-4 text-muted fw-normal">Por favor, ingresa tus credenciales</p>
                        </div>
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="signin-email" class="form-label text-default">Usuario (Email)</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="signin-email"
                                    v-model="user.email"
                                    placeholder="Ingrese su correo electrónico"
                                    :disabled="processing"
                                >
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="signin-password" class="form-label text-default d-block">Contraseña</label>
                                <div class="position-relative">
                                    <PasswordInput
                                        :initialValue="user.password"
                                        name="psw"
                                        id="password"
                                        placeholder="Contraseña"
                                        required
                                        :disabled="processing"
                                    />
                                </div>
                                <div class="mt-2">
                                    <div class="form-check d-flex gap-2 flex-wrap">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="remember"
                                            v-model="user.remember"
                                        >
                                        <label class="form-check-label flex-grow-1" for="defaultCheck1">
                                            Recuérdame
                                        </label>
                                        <!-- Desactivamos temporalmente el reset de contraseña -->
                                        <!-- <Link
                                            :href="`${baseUrl}/pages/authentication/reset-password/basic`"
                                            class="float-end link-danger fw-medium fs-12"
                                        >¿Olvidaste tu contraseña?</Link> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button
                                class="btn btn-primary"
                                @click.prevent="login"
                                :disabled="processing"
                            >
                                {{ processing ? 'Iniciando...' : 'Ingresar' }}
                            </button>
                        </div>

                        <!-- Opciones de login social (deshabilitadas por ahora) -->
                        <!--
                        <div class="text-center my-3 authentication-barrier">
                            <span class="op-4 fs-13">O</span>
                        </div>
                        <div class="d-grid mb-3">
                            <button
                                class="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill mb-3"
                                disabled
                            >
                                <span class="avatar avatar-xs">
                                    <BaseImg src="/images/media/apps/google.png" alt="" />
                                </span>
                                <span class="lh-1 ms-2 fs-13 text-default fw-medium">Ingresar con Google</span>
                            </button>
                            <button
                                class="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill"
                                disabled
                            >
                                <span class="avatar avatar-xs">
                                    <BaseImg src="/images/media/apps/facebook.png" alt="" />
                                </span>
                                <span class="lh-1 ms-2 fs-13 text-default fw-medium">Ingresar con Facebook</span>
                            </button>
                        </div>
                        -->

                        <!-- Registro (deshabilitado) -->
                        <!--
                        <div class="text-center mt-3 fw-medium">
                            ¿No tienes cuenta aún?
                            <Link :href="`${baseUrl}/pages/authentication/sign-up/basic`" class="text-primary">Regístrate</Link>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>