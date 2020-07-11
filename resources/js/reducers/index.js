import { combineReducers } from 'redux'
//reducerだと一般的名称で判別が難しいのでformに名称を変更する
import { reducer as form } from 'redux-form'
import events from './events'

export default combineReducers({ events, form })
