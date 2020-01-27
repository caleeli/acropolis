// ***********************************************************
// This example support/index.js is processed and
// loaded automatically before your test files.
//
// This is a great place to put global configuration and
// behavior that modifies Cypress.
//
// You can change the location of this file or turn off
// automatically serving support files with the
// 'supportFile' configuration option.
//
// You can read more here:
// https://on.cypress.io/configuration
// ***********************************************************

// Import commands.js using ES2015 syntax:
import './commands'
import '@cypress/code-coverage/support'
import '@foreachbe/cypress-tinymce'

// Alternatively you can use CommonJS syntax:
// require('./commands')

beforeEach(() => {
    // Reset database
    cy.exec('php artisan migrate:fresh --seed');

    // Routes
    cy.server();
    cy.route('/api/data/user/1/messages*').as('getMessages');
    cy.route('/api/data/messages/*').as('loadMessage');
    cy.route('/api/data/user/0/aportes*').as('getAportesInicial');
    cy.route('/api/data/user/1/aportes*').as('getAportes/1');
    cy.route('put', '/api/data/aportes/*').as('updateAporte');
    cy.route('post', '/api/data/user/1/aportes').as('postAporte');
    cy.route('post', '/api/uploadfile').as('uploaded');
    cy.route('/api/data/aporte/1*').as('getAporte(1)');
});
