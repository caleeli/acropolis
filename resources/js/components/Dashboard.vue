<template>
<svg width="100%" :viewBox="`0 0 ${width} ${height}`" class="dashboard-circle">
	<foreignObject v-for="(node, index) in ordenado" :key="`dashboard-item-${index}`"
		class="node" :x="cos(index)" :y="sin(index)" :width="80" height="100"
		style="cursor: pointer;"
		@mousemove="mousemove(node)">
		<label v-if="Number(node.attributes.total) < 0" class="badge badge-danger position-absolute mt-4" style="left: 0px">{{ format(Math.abs(node.attributes.total)) }}</label>
		<label v-else class="badge badge-success position-absolute mt-4" style="left: 0px">{{ format(Math.abs(node.attributes.total)) }}</label>
		<i class="dashboard-icon" :class="node.attributes.icono"></i>
		<div class="dashboard-text">{{ node.attributes.nombre }}</div>
	</foreignObject>
	<circle :r="radio" :cx="width*0.5" :cy="height*0.5" fill="transparent"
		stroke="tomato"
		:stroke-width="ancho"
	/>
	<circle :r="radio" :cx="width*0.5" :cy="height*0.5" fill="transparent"
		stroke="#38c172"
		:stroke-width="ancho"
		:stroke-dasharray="`${porcentaje()} ${width}`"
		stroke-dashoffset="0"
	/>
	<circle :r="radio-10" :cx="width*0.5" :cy="height*0.5" fill="#00aaa0"
		stroke="#024b42"
		stroke-width="1"
		@click="verDetalle"
	/>
	<foreignObject
		:x="width*0.5-radio"
		:y="height*0.5-radio"
		:width="2*radio"
		:height="2*radio"
		dominant-baseline="middle"
		text-anchor="middle"
		font-size="1.5em"
		fill="black"
		class="saldo"
	>
		<div class="d-flex align-items-center h-100">
			<div class="w-100 text-center">
				<div @mousemove="mouseCaja">
					<router-link
						class="text-dark"
						:to="{ path:'/diario', query: { filter: 'whereCaja', title: 'Caja' } }"
						data-cy="saldo-caja"
					>
						{{ format($root.totales.saldoCaja) }}
					</router-link>
				</div>
				<div @mousemove="mouseCuenta">
					<router-link
						class="text-dark"
						:to="{ path:'/diario', query: { filter: 'whereCuenta', title: 'Cuenta' } }"
						data-cy="saldo-cuenta"
					>
						{{ format($root.totales.saldoCuenta) }}
					</router-link>
				</div>
			</div>
		</div>
	</foreignObject>
</svg>
</template>

<script>
const width = 442;
const height = 461;
const initialAngle = Math.PI / 5;
export default {
  mixins: [window.ResourceMixin],
	props: {
		value: {
			type: Array,
			default() {
				return this.$api.economia_categoria.array({per_page: 10, filter: ['whereTieneDiario']});
			}
		}
	},
	data () {
		return {
			overNode: null,
			overLibreta: null,
			width,
			height,
			radio: width *0.2,
			ancho: 16,
		};
	},
	computed: {
		ordenado() {
			return this.value.sort((a, b) => {
				return Number(a.attributes.total) < Number(b.attributes.total);
			});
		},
	},
	methods: {
		mouseCuenta() {
			if ( null !== this.overNode || 'cuenta' !== this.overLibreta) {
				this.overNode = null;
				this.overLibreta = 'cuenta';
				this.$emit('hover', {
					attributes: {
						nombre: 'en cuenta bancaria',
					}
				}, 'cuenta');
			}
		},
		mouseCaja() {
			if ( null !== this.overNode || 'caja' !== this.overLibreta) {
				this.overNode = null;
				this.overLibreta = 'caja';
				this.$emit('hover', {
					attributes: {
						nombre: 'en caja',
					}
				}, 'caja');
			}
		},
		mousemove(node) {
			if ( node !== this.overNode || null !== this.overLibreta ) {
				this.overNode = node;
				this.overLibreta = null;
				this.$emit('hover', node, null);
			}
		},
		verDetalle() {
			this.$router.push({ path: '/diario' });
		},
		format(value) {
			return new Intl.NumberFormat("en-US", {style: 'currency', currency: 'BOB' })
				.format(value)
				.substr(3);
		},
		porcentaje() {
			return (this.$root.totales.ingresos / (this.$root.totales.ingresos + this.$root.totales.egresos)) * this.radio * 2 * Math.PI;
		},
		porcentajeOffset() {
			return initialAngleTubo * this.radio;
		},
		cos(index) {
			return (this.calcAngle(index).cos * .5 + .5) * (width - 80);
		},
		sin(index) {
			return (this.calcAngle(index).sin * .5 + .5) * (height - 100);
		},
		calcAngle(index) {
			const a = initialAngle + (index / this.value.length * Math.PI * 2);
			let cos = Math.cos(a);
			let sin = Math.sin(a);
			if (Math.abs(cos) > Math.abs(sin)) {
				sin = sin / Math.abs(cos);
				cos = cos / Math.abs(cos);
			} else {
				cos = cos / Math.abs(sin);
				sin = sin / Math.abs(sin);
			}
			return {cos: cos, sin};
		}
	},
};
</script>

<style>
.node {
  color: #014B41;
	text-align: center;
	position: relative;
}
.node label {
	opacity: 0.8;
}
.dashboard-icon {
	font-size: 4em;
	margin-bottom: 4px;
}
.dashboard-text {
	font-size: 0.75em;
	line-height: 1em;
}
.saldo {
	cursor: pointer;
	color: black;
}
.dashboard-circle {
	max-width: 400px;
}
</style>
