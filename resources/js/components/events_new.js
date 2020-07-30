import React, { Component } from 'react';
import { connect } from 'react-redux'
import { Field, reduxForm } from 'redux-form'
import { Link } from 'react-router-dom';
import { postEvent } from '../actions';

//イベント新規作成コンポーネント
class EventsNew extends Component {
  constructor(props) {
    super(props)
    this.onSubmit = this.onSubmit.bind(this)
  }

  renderField(field){
    const{ input, label, type, meta: { touched, error } } = field

    // 入力した内容をそのまま渡す。エラーがあればバリデーションのメッセージを表示する。
    return (
      <div>
        <input {...input} placeholder={label} type={type} />
        {touched && error && <span>{error}</span>}
      </div>
    )
  }

  //トップページの履歴をpush
  async onSubmit(values) {
    await this.props.postEvent(values)
    this.props.history.push('/')
  }

  /*
    pristine -> 入力欄が空なら非活性にする。
    submitting -> ボタンを連打しても一度しかデータが送られないようにする。
  */
  render(){
    const { handleSubmit, pristine, submitting } = this.props

    return (
      <form onSubmit={handleSubmit(this.onSubmit)}>
        <div><Field label="title" name="title" type="text" component={this.renderField}/></div>
        <div><Field label="Body" name="body" type="text" component={this.renderField}/></div>

        <div>
          <input type="submit" value="submit" disabled={pristine || submitting} />
          <Link to="/" >Cancel</Link>
        </div>
      </form>
    )
  }
}

//バリデーションのルールを定義する
const validate = values => {
    const errors = {}

    //title,bodyが空ならエラー
    if (!values.title) errors.title = "titleを入力してください"
    if (!values.body) errors.body = "bodyを入力してください"

    return errors
}

const mapDispatchToProps = ({ postEvent })

export default connect(null, mapDispatchToProps)(
  reduxForm({ validate, form: 'eventNewForm' })(EventsNew)
)
