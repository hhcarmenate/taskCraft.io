import { useWorkspaceStore } from '@/stores/useWorkspaceStore.js'
import { useBoardStore } from '@/stores/useBoardStore.js'

export default function listenChannels() {

  const listenPublicChannels = () => {
    window.Echo.channel('test-channel')
      .listen('TestBroadcast', (e) => {
        console.log('Event received: ', e.message)
      })
  }

  const listenCurrentWorkspace = (workspaceId) => {
    const workspace = useWorkspaceStore()

    window.Echo.private(`workspace.${workspaceId}`)
      .listen('WorkspaceUpdated', (event) => {
        workspace.updateWorkspaceFromBroadcast(event)
      })

    window.Echo.private(`created_board.${workspaceId}`)
      .listen('BoardCreated', (event) => {
        workspace.addNewBoardFromBroadcast(event)
      })
  }

  const listenBoard = (boardId) => {
    const board = useBoardStore()

    window.Echo.private(`updated_board.${boardId}`)
      .listen('BoardUpdated', (event) => {
        board.updateBoardFromBroadcast(event)
      })
  }


  return {
    listenPublicChannels,
    listenCurrentWorkspace,
    listenBoard
  }
}
