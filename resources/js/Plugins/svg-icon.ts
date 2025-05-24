import { App, computed, defineComponent, h } from 'vue';

export default {
    install(app: App) {
        app.component(
            'SvgIcon',
            defineComponent({
                props: {
                    name: {
                        type: String,
                        required: true,
                    },
                    width: {
                        type: String,
                        default: '24px',
                    },
                    height: {
                        type: String,
                        default: '24px',
                    },
                    class: {
                        type: String,
                        default: '',
                    },
                },
                setup(props) {
                    const icons = import.meta.glob('@/assets/icons/*.svg', {
                        eager: true,
                        query: '?raw',
                        import: 'default',
                    });

                    const iconContent = computed(() => {
                        const iconPath = Object.keys(icons).find((icon) =>
                            icon.endsWith(props.name + '.svg'),
                        );

                        if (!iconPath) {
                            console.warn(`Icon "${props.name}" not found.`);
                            return '';
                        }

                        // Modify the raw SVG content to set width and height
                        let svgContent = icons[iconPath];
                        const parser = new DOMParser();
                        const svgDoc = parser.parseFromString(
                            svgContent,
                            'image/svg+xml',
                        );
                        const svgElement = svgDoc.querySelector('svg');

                        if (svgElement) {
                            svgElement.setAttribute('width', props.width);
                            svgElement.setAttribute('height', props.height);
                            svgElement.setAttribute('class', props.class);
                            svgContent = svgElement.outerHTML;
                        }

                        return svgContent;
                    });

                    return () =>
                        h('div', {
                            class: 'svg-icon',
                            innerHTML: iconContent.value,
                            style: {
                                width: props.width,
                                height: props.height,
                            },
                        });
                },
            }),
        );
    },
};
