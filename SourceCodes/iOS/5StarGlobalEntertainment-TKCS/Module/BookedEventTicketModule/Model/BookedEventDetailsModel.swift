//
//  BookedEventDetailsModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 23/03/23.
//

import Foundation
// MARK: - BookedEventDetails--

struct BookedEventDetailModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: BookedEventDetails?
}

// MARK: - BookedEventDetails--
struct BookedEventDetails: Codable {
    var totalTicketsSold, guestsArrived, ticketsLeft: Int?

    enum CodingKeys: String, CodingKey {
        case totalTicketsSold = "total_tickets_sold"
        case guestsArrived = "guests_arrived"
        case ticketsLeft = "tickets_left"
    }
}
