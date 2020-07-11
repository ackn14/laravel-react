import React, { Component } from 'react';
import { connect } from 'react-redux'
import { Field, reduxForm } from 'redux-form'
import { Link } from 'react-router-dom';
import { getEvent, deleteEvent, putEvent } from '../actions';

//イベント新規作成コンポーネント
class EventsShow extends Component {
  constructor(props) {
    super(props)
    this.onSubmit = this.onSubmit.bind(this)
    this.onDeleteClick = this.onDeleteClick.bind(this)
  }

  /*
    詳細画面のURLに直接アクセスした際に、データを適宜取得する
  */
  componentDidMount(){
    const { id } = this.props.match.params
    if(id) this.props.getEvent(id)
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

  // クリックした時に削除する
  async onDeleteClick() {
    const { id } = this.props.match.params
    await this.props.deleteEvent(id)
    this.props.history.push('/')
  }

  //トップページの履歴をpush
  async onSubmit(values) {
    await this.props.putEvent(values)
    this.props.history.push('/')
  }

  /*
    pristine -> 入力欄が空なら非活性にする。
    submitting -> ボタンを連打しても一度しかデータが送られないようにする。
    invalid -> バリデーションが発生している時にsubmitが出来ないように制御する
  */
  render(){
    const { handleSubmit, pristine, submitting, invalid } = this.props

    return (
      <form onSubmit={handleSubmit(this.onSubmit)}>
        <div><Field label="title" name="title" type="text" component={this.renderField}/></div>
        <div><Field label="Body" name="body" type="text" component={this.renderField}/></div>

        <div>
          <input type="submit" value="submit" disabled={pristine || submitting || invalid} />
          <Link to="/" >Cancel</Link>
          <Link to="/" onClick={this.onDeleteClick} >Delete</Link>
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

const mapStateToProps = (state, ownProps) => {
  const event = state.events[ownProps.match.params.id]
  return { initialValues: event, event }
}

const mapDispatchToProps = ({ deleteEvent, getEvent, putEvent })

export default connect(mapStateToProps, mapDispatchToProps)(
  reduxForm({ validate, form: 'eventShowForm', enableReinitialize: true })(EventsShow)
)
