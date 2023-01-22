import Maps from './Maps.vue';

// More on default export: https://storybook.js.org/docs/vue/writing-stories/introduction#default-export
export default {
    title: 'Example/Maps',
    component: Maps,
    // More on argTypes: https://storybook.js.org/docs/vue/api/argtypes
    argTypes: {
        place_id: String,
    },
};

// More on component templates: https://storybook.js.org/docs/vue/writing-stories/introduction#using-args
const Template = (args) => ({
    // Components used in your story `template` are defined in the `components` object
    components: { Maps },
    // The story's `args` need to be mapped into the template through the `setup()` method
    setup() {
        return { args };
    },
    // And then the `args` are bound to your component with `v-bind="args"`
    template: '<Suspense><Maps v-bind="args" /></Suspense>',
});

export const Example = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args
Example.args = {
    place_id: 'ChIJ30yC0hekm0cRljimUjXQ5Fg',
};
