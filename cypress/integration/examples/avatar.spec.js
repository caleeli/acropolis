
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

    it('Change avatar image', () => {
        cy.get('#user-avatar').click();
        cy.get('input[type=file]').then(function (el) {
            cy.uploadFile('input[type=file]', 'avatar.jpeg', 'image/jpeg').then(() => {
                el[0].dispatchEvent(new Event('change', { bubbles: true }));
            });
        })
        cy.wait(1000);
    })

})
