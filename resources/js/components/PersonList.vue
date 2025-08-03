<script setup>

import Icon from "@/components/Icon.vue";
import NavLink from "@/components/NavLink.vue";
import {useForm, usePage} from "@inertiajs/vue3";

const confirma = function(text) {
	return confirm(text);
}

defineProps({
	persons: {
		type: Array,
	},
	exp: {
		type: Boolean,
		required: false,
		default: false
	},
	paginate: {
		type: String
	}
});
const form = useForm();
</script>

<template>
			<div class="text-gray-900 bg-slate-50">
				<table class="border-collapse table-auto w-full text-sm">
					<thead>
					<tr>
						<th width="40" class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">ID</th>
						<th class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Имя</th>
						<th class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Опыт</th>
						<th class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Город</th>
						<th v-if="exp" class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Сроки</th>
						<th class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left"></th>
					</tr>
					</thead>
					<tbody class="bg-white">
					<tr v-for="person in persons">
						<td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ person.id }}</td>
						<td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"><NavLink :href="route('person.show', person.id)">{{ person.fio }}</NavLink></td>
						<td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ person.position }}</td>
						<td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ person.city }}</td>
						<td v-if="person.exp" class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
							<div>
								<div v-for="tag in person.tags">
									<template v-if="person.exp[tag.id]">
										{{ tag.name.ru }} - {{ person.exp[tag.id] }} мес
									</template>
								</div>
							</div>
						</td>
						<td width="120" class="border-b border-slate-100 dark:border-slate-700 p-4">
							<div class="flex gap-1 items-center">
								<Link class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-[4px] text-sm px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" :href="route('person.edit', person.id)">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
										<path d="m15 5 4 4"/>
									</svg>
								</Link>
								<form @submit.prevent="confirma('Удалить') && form.delete(route('person.delete', person.id))" method="POST">
									<button type="submit" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-[4px] text-sm px-3 py-2 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
									</button>
								</form>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div v-if="paginate" class="mt-8" v-html="paginate"></div>

</template>

<style scoped>

</style>
