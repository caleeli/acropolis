
context('Actions', () => {
    beforeEach(() => {
        cy.visit('http://localhost:9097');
        cy.viewport(375, 667);

        // Login
        cy.get('#login').click();
        cy.get('#email').type('economia-lapaz@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#submit').click();
    })

    it('Nuevo mensaje de aporte mensual', () => {
        cy.get('#new-message').click();
        cy.get('#msg-1').click();
        cy.get('#enviar').click();
        cy.wait('@getMessages');
        cy.get('.mensaje:first-child').click();
        cy.wait('@loadMessage');
        cy.get('a:contains("Registrar aporte")').click();
        cy.get('input[type=file]').then(function (el) {
            cy.uploadFile('input[type=file]', 'avatar.jpeg', 'image/jpeg').then(() => {
                el[0].dispatchEvent(new Event('change', { bubbles: true }));
            });
        })
    })
})
