import Badge from './Badge.vue';

// More on default export: https://storybook.js.org/docs/vue/writing-stories/introduction#default-export
export default {
    title: 'Example/Badge',
    component: Badge,
    // More on argTypes: https://storybook.js.org/docs/vue/api/argtypes
    argTypes: {
        label: String,
        dot: Boolean,
    },
};

// More on component templates: https://storybook.js.org/docs/vue/writing-stories/introduction#using-args
const Template = (args) => ({
    // Components used in your story `template` are defined in the `components` object
    components: { Badge },
    // The story's `args` need to be mapped into the template through the `setup()` method
    setup() {
        return { args };
    },
    // And then the `args` are bound to your component with `v-bind="args"`
    template: '<Badge v-bind="args"></Badge>',
});

export const Example = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args
Example.args = {
    label: 'Badge',
};

export const WithDot = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args
WithDot.args = {
    label: 'Badge',
    dot: true,
};
