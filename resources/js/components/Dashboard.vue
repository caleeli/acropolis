<template>
<svg width="100%" :viewBox="`0 0 ${width} ${height}`">
	<foreignObject v-for="(node, index) in value" :key="`dashboard-item-${index}`"
		class="node" :x="cos(index)" :y="sin(index)" :width="80" height="100">
		<i class="dashboard-icon" :class="node.attributes.icono"></i>
		<div class="dashboard-text">{{ node.attributes.nombre }}</div>
	</foreignObject>
  	<circle :r="radio" :cx="width*0.5" :cy="height*0.5" fill="transparent"
		stroke="tomato"
		:stroke-width="ancho" />
  	<circle :r="radio" :cx="width*0.5" :cy="height*0.5" fill="transparent"
		stroke="dodgerblue"
		:stroke-width="ancho"
		:stroke-dasharray="`${porcentaje()} ${width}`"
		stroke-dashoffset="0" />
  	<circle :r="radio-10" :cx="width*0.5" :cy="height*0.5" fill="#00aaa0"
		stroke="#024b42"
		stroke-width="1" />
  	<text :x="width*0.5"
		:y="height*0.5"
		dominant-baseline="middle"
		text-anchor="middle"
		font-size="1.5em"
		fill="black">
		4.000 Bs
	</text>	
</svg>
</template>

<script>
const width = 442;
const height = 461;
export default {
  mixins: [window.ResourceMixin],
	props: {
		value: {
			type: Array,
			default() {
				return this.$api.economia_categoria.array({per_page: 10});
			}
		}
	},
	data () {
		return {
			width,
			height,
			radio: width *0.2,
			ancho: 16,
		};
	},
	methods: {
		porcentaje() {
			return 0.3 * this.radio * 2 * Math.PI;
		},
		cos(index) {
			return (this.calcAngle(index).cos * .5 + .5) * (width - 80);
		},
		sin(index) {
			return (this.calcAngle(index).sin * .5 + .5) * (height - 100);
		},
		calcAngle(index) {
			const a = index / this.value.length * Math.PI * 2;
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
}
.dashboard-icon {
	font-size: 4em;
	margin-bottom: 4px;
}
.dashboard-text {
	font-size: 0.75em;
	line-height: 1em;
}
</style>
