import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class Example extends Component {
  //JSONを格納する空配列posts[]を用意
  constructor() {
    super();

    this.state = {
        posts: []
    };
  }
  //posts[]にJSONを格納
  componentDidMount() {
      axios
          .get('/api/posts')
          .then(response => {
              this.setState({posts: response.data});
          })
          .catch(() => {
              console.log('通信に失敗しました');
          });
  }

  renderPosts() {
      return this.state.posts.map(post => {
        console.log(this.state.posts)
          return (
              <li key={post.key}>
                  {post.name}: {post.content}
              </li>
          );
      });
  }

  render() {
      return (
          <div className="container">
              <ul>
                  {this.renderPosts()}
              </ul>
          </div>
      );
  }
}

if (document.getElementById('example')) {
  ReactDOM.render(<Example />, document.getElementById('example'));
}
