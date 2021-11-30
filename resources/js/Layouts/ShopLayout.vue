<template>
    <div class="bg-white">
        <div>
            <!--            <shopping-cart-dialog :open="basketOpen"/>-->
            <!-- Mobile filter dialog -->
            <shop-filters-phone :filters="filters" @close="togglePhoneMenu" @onUpdate="updateProducts"/>

            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative z-10 flex items-baseline justify-between pt-24 pb-6 border-b border-gray-200">
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Bestel Snel</h1>

                    <div class="flex items-center">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                    Sort
                                    <ChevronDownIcon
                                        class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                        aria-hidden="true"/>
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition ease-out duration-100"
                                        enter-from-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-for="option in sortOptions" :key="option.name">
                                            <div
                                                @click.prevent="sortOptionClicked(option)"
                                                :class="[option.active ? 'font-medium text-gray-900' : 'text-gray-500', option.active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm']"
                                                class="cursor-pointer"
                                            >
                                                {{ option.label }}
                                            </div>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                            <!--                            <MenuItem>-->
                            <!--                                TEST-->
                            <!--                            </MenuItem>-->
                        </Menu>

                        <button type="button" class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500 lg:hidden"
                                @click="togglePhoneMenu(true)">
                            <span class="sr-only">Filters</span>
                            <FilterIcon class="w-5 h-5" aria-hidden="true"/>
                        </button>

                        <inertia-link :href="route('basket')" type="button" class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Winkelmand</span>
                            <ShoppingCartIcon class="w-5 h-5" aria-hidden="true"/>
                        </inertia-link>

                        <inertia-link v-if="$page.props.user" :href="route('dashboard.home')" type="button" class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Dashboard</span>
                            <UserIcon class="w-5 h-5" aria-hidden="true"/>
                        </inertia-link>

                        <inertia-link v-if="!$page.props.user" :href="route('login')" type="button" class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500">
                            <span>Inloggen</span>
                        </inertia-link>
                        <inertia-link v-if="!$page.props.user" :href="route('register')" type="button" class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500">
                            <span>Registreren</span>
                        </inertia-link>

                    </div>
                </div>

                <section aria-labelledby="products-heading" class="pt-6 pb-24">
                    <h2 id="products-heading" class="sr-only">Products</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-8 gap-y-10">
                        <!-- Filters -->
                        <form class="hidden lg:block">
                            <shop-filters @onUpdate="updateProducts"/>
                        </form>

                        <!-- Product grid -->
                        <div class="lg:col-span-3">
                            <!-- Replace with your content -->
                            <slot></slot>
                            <!--                            <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 lg:h-full" />-->
                            <!-- /End replace -->
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</template>

<script>
import {
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem, MenuItems, TransitionChild, TransitionRoot
} from "@headlessui/vue";
import {ChevronDownIcon, FilterIcon, MinusSmIcon, PlusSmIcon, ViewGridIcon, ShoppingCartIcon, UserIcon} from "@heroicons/vue/solid";
import {XIcon} from "@heroicons/vue/outline";
import ShopFiltersPhone from "../Components/ShopFiltersPhone";
import ShopFilters from "../Components/ShopFilters";
import ShoppingCartDialog from "../Components/ShoppingCartDialog";

export default {
    name: "ShopLayout",
    components: {
        ShoppingCartDialog,
        ShopFilters,
        ShopFiltersPhone,
        Dialog,
        DialogOverlay,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
        ChevronDownIcon,
        FilterIcon,
        MinusSmIcon,
        PlusSmIcon,
        ViewGridIcon,
        ShoppingCartIcon,
        XIcon,
        UserIcon,
    },
    props: {
        sortOptions: Array,
        filters: Array,
    },
    data() {
        return {
            mobileFiltersOpen: false,
            basketOpen: false,
        }
    },
    methods: {
        togglePhoneMenu(state) {
            this.mobileFiltersOpen = state;
        },
        toggleBasket(state) {
            this.basketOpen = state;
        },
        updateProducts() {
            this.$emit('shopFiltersUpdated');
        },
        sortOptionClicked(option) {
            let newOptions = [];

            this.sortOptions.forEach(opt => {
                let theOption = opt;
                theOption.active = theOption.id === option.id;
                newOptions.push(opt);
            });

            this.$emit('filtersUpdated', newOptions);
        }
    }
}
</script>
