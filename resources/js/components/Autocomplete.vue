<template>
	<div>

		<input :class="{ 'is-loading': loading}" type="text" placeholder="Начните вводить" v-model="query" @keydown.enter.stop.prevent="doEnter" v-on:keyup="search" @focusin="showDropdown" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full">
		<div class="relative" v-if="opened && results.length">
			<div class="absolute z-50 mt-2 rounded-md shadow-lg w-48 ltr:origin-top-right rtl:origin-top-left">
				<ul class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
					<li class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none cursor-pointer" v-for="(result, index) in results" @click="clickItem(result, index)">
						{{ result.name.ru }}
					</li>
				</ul>
			</div>
		</div>
		<div class="tags">
			<span class="tag" v-for="(tag, index) in tags">
				{{ tag.name.ru }} <span class="tag-remove" @click="removeTag(index)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></span>
			</span>
		</div>
	</div>
</template>
<script>
import {debounce} from "@/./utils.js";
export default{
	data(){
		return {
			query: '',
			results: [],
			loading: false,
			opened: false
		}
	},
	props: [
		'url',
		'tags'
	],
	created() {
		this.search = debounce(()=>{
			this.results = [];
			if (this.query.length > 1) {
				this.loading = true;
				axios.get(this.url, {params: {search: this.query}})
				.then(response => {
					this.loading = false;
					if (response.data.length) {
						this.results = response.data;
					};
					let oTag = this.tags.find((x) => {
						return x.name.ru == this.query;
					});
					if (!oTag) {
						this.results.splice(this.results.length, 0, {
								id: -1,
								name: {
									ru: this.query,
								}
							}
						);
					}

					this.opened = true;
				})
				;
			}
			// call fetch API to get results
		}, 500);
	},
	methods: {
		showDropdown() {
			if (this.results.length) {
				this.opened = true;
			}
		},
		removeTag(index) {
			this.tags.splice(index, 1);
		},
		clickItem(tag, index) {
			this.addTag(tag, index);
			this.opened = false;
		},
		addTag(tag, index) {
			if (this.tags.length) {
				let oTag = this.tags.find((x) => {
					return x.name.ru == tag.name.ru;
				});
				if (!oTag) {
					this.tags.splice(this.tags.length, 0, tag);
				}
			} else {
				this.tags.splice(this.tags.length, 0, tag);
			}
			this.results.splice(index, 1);
		},
		doEnter(event) {
			if (this.results.length == 1) {
				this.addTag(this.results[0]);
				this.results = [];
				this.query = '';
				return false;
			}
		},
	}
}
</script>
<style scoped>
	.tags {
		cursor: default;
		display: flex;
		flex-wrap: wrap;
		gap: 5px;
		margin-top: 5px;
	}
	.tag {
		display: inline-flex;
		-webkit-align-items: center;
		-webkit-box-align: center;
		-ms-flex-align: center;
		align-items: center;
		height: 24px;
		gap: 5px;
		line-height: 22px;
		background-color: #f6f6f6;
		border: 1px solid #e8e8e8;
		border-radius: 2px;
		box-sizing: content-box;
		padding: 0 4px 0 10px;
		outline: 0;
		overflow: hidden;
	}
	.tag-remove {
		padding: 3px;
		cursor: pointer;
		cursor: pointer;
	}
	.tag-remove svg {
		display: block;
	}
	.tag-remove:hover svg path {
		stroke: #d00;
	}
</style>
