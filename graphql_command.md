# Example request GraphQL API   

## SignUp (without file upload)
    
        mutation {
            CreateAccount(input: {
                name: "ahmad"
                email: "rocketmail@gmail.com"
                password: "PasswordIniRahasia"
                phone_number: "08123456789"
                avatar: "/images/some-imags.jpg"
            }) {
                ... on Response {
                message
                }
            }
        }

## Login

        mutation {
            Login(input: {
                email: "rocketmail@gmail.com"
                password: "PasswordIniRahasia"
            }) {
                
                ... on ResponseError {
                message
                }
                
                ... on LoginSuccessResponse {
                access_token
                }
            }
        }