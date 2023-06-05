import React, { Component } from 'react';

class App extends Component {

    render() {
        return (
            <div>

                <h1>Welcome to this react app !!!!!!</h1>
                <h1>{process.env.NODE_ENV}</h1>
            </div>
        );
    }

}

export default App;