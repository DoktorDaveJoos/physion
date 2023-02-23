import MultiStep from './MultiStep.vue';

// More on default export: https://storybook.js.org/docs/vue/writing-stories/introduction#default-export
export default {
    title: 'Example/MultiStep',
    component: MultiStep,
    // More on argTypes: https://storybook.js.org/docs/vue/api/argtypes
    argTypes: {},
};

// More on component templates: https://storybook.js.org/docs/vue/writing-stories/introduction#using-args
const Template = (args) => ({
    // Components used in your story `template` are defined in the `components` object
    components: { MultiStep },
    // The story's `args` need to be mapped into the template through the `setup()` method
    setup() {
        return { args };
    },
    // And then the `args` are bound to your component with `v-bind="args"`
    template: `
      <MultiStep v-bind="args">
        <el-form>
          <el-form-item label="Name">
            <el-input v-model="name"></el-input>
          </el-form-item>
            <el-button @click="">Next</el-button>
        </el-form>
      </MultiStep>
    `,
});

export const Basic = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args

export const WithHeader = Template.bind({});

WithHeader.args = {
    header: 'Some Header',
};
