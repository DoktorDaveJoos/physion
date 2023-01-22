import BuildingDetail from './BuildingDetail.vue';

// More on default export: https://storybook.js.org/docs/vue/writing-stories/introduction#default-export
export default {
    title: 'Example/BuildingDetail',
    component: BuildingDetail,
    // More on argTypes: https://storybook.js.org/docs/vue/api/argtypes
    argTypes: {
        context: String,
        order: Object,
    },
};

// More on component templates: https://storybook.js.org/docs/vue/writing-stories/introduction#using-args
const Template = (args) => ({
    // Components used in your story `template` are defined in the `components` object
    components: { BuildingDetail },
    // The story's `args` need to be mapped into the template through the `setup()` method
    setup() {
        return { args };
    },
    // And then the `args` are bound to your component with `v-bind="args"`
    template: '<Suspense><building-detail v-bind="args" /></Suspense>',
});

export const Example = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args

Example.args = {
    context: 'bedarf',
};

export const WithOrder = Template.bind({});

WithOrder.args = {
    context: 'bedarf',
    order: {
        id: 'wR0CSgsMk',
        customer_id: 2,
        type: 'bedarfsausweis',
        status: 'created',
        paid: false,
        product_id: 2,
        product_type: 'AppModelsBedarfsausweis',
        meta: {
            completed: ['general', 'details'],
        },
        created_at: '2023-01-22T15:10:33.000000Z',
        updated_at: '2023-01-22T16:24:31.000000Z',
        product: {
            id: 2,
            reason: 'Modernisierung/Änderung',
            street_address: 'Edensbach 8',
            zip: '88289',
            city: 'Waldburg',
            place_id: 'ChIJ30yC0hekm0cRljimUjXQ5Fg',
            type: 'Einfamilienhaus',
            additional_type: 'Freistehend',
            floor_area: 123,
            housing_units: 1,
            construction_year: '2005',
            construction_year_heating: '2005',
            ventilation: 'Fensterlüftung',
            cellar: 'Kein Keller',
            renewables: 'Solar',
            renewables_reason: 'Heizen und Warmwasser',
            cooling: 'Aus Strom',
            cooling_count: '1',
            cooling_service: '2023-12-31T23:00:00.000000Z',
            side_a: null,
            side_b: null,
            maps: 'agreed',
            orientation: null,
            created_at: '2023-01-22T15:10:33.000000Z',
            updated_at: '2023-01-22T16:24:31.000000Z',
        },
        customer: {
            id: 2,
            name: 'Bertl',
            email: 'bertl@t-hotline.de',
            phone: null,
            address_line_1: null,
            address_line_2: null,
            postal_code: null,
            city: null,
            state: null,
            country: null,
            created_at: '2023-01-22T15:10:33.000000Z',
            updated_at: '2023-01-22T15:10:33.000000Z',
        },
    },
};
