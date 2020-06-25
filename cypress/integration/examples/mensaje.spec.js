
context('Usuario Economía', () => {
    beforeEach(() => {
        // Login
        cy.get('#login').click();
        cy.get('#email').type('economia-lapaz@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#submit').click();
    })

    it('Nuevo mensaje', () => {
        cy.get('#new-message').click();
        cy.get('#msg-1').click();
        cy.get('#cat-2').click();
        cy.get('#icon-fas-fa-book-reader').click();
        cy.get('#titulo').clear();
        cy.get('#titulo').type('Mensaje sobre escolástica', { parseSpecialCharSequences: false });
        cy.get('#enviar').click();
        cy.wait(1000);
    })

    it('Mensaje erróneo, variable sin $', () => {
        cy.get('#new-message').click();
        cy.get('#msg-1').click();
        cy.get('#cat-2').click();
        cy.get('#icon-fas-fa-book-reader').click();
        cy.get('#titulo').clear();
        cy.get('#titulo').type('Mensaje para {{nombre}}', { parseSpecialCharSequences: false });
        cy.get('#enviar').click();
        cy.wait(1000);
    })

    /*it('Ver mensaje', () => {
        cy.dbSeed('SpecAportesSeeder');
        cy.reload();
        cy.get('.mensaje:first-child').click();
        cy.wait(1000);
        cy.get('#back').click();
    })*/
})
